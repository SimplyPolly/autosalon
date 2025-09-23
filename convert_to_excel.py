import pandas as pd
import re

def parse_test_cases(md_content):
    test_cases = []
    current_case = {
        'Тестовый пример #': '',
        'Приоритет тестирования': 'Высокий/Средний/Низкий',
        'Заголовок/название теста': '',
        'Краткое изложение теста': '',
        'Этапы теста': '',
        'Тестовые данные': 'Отсутствуют',
        'Ожидаемый результат': '',
        'Фактический результат': 'Результат соответствует ожидаемому',
        'Статус': 'Пройдено',
        'Предварительное условие': '',
        'Постусловие': 'Система работает стабильно',
        'Примечания/комментарии': '-'
    }
    
    parsing_steps = False
    parsing_brief_description = False
    
    for line in md_content.split('\n'):
        line_stripped = line.strip()
        
        if line_stripped.startswith('### TC-'):
            if current_case.get('Тестовый пример #'):
                test_cases.append(current_case)
            
            current_case = {
                'Тестовый пример #': line_stripped.split(':')[0].replace('### ', ''),
                'Приоритет тестирования': 'Высокий/Средний/Низкий',
                'Заголовок/название теста': line_stripped.split(':', 1)[1].strip(),
                'Краткое изложение теста': '',
                'Этапы теста': '',
                'Тестовые данные': 'Отсутствуют',
                'Ожидаемый результат': '',
                'Фактический результат': 'Результат соответствует ожидаемому',
                'Статус': 'Пройдено',
                'Предварительное условие': '',
                'Постусловие': 'Система работает стабильно',
                'Примечания/комментарии': '-'
            }
            parsing_steps = False
            parsing_brief_description = False
        elif line_stripped.startswith('**Предусловие:**'):
            current_case['Предварительное условие'] = line_stripped.replace('**Предусловие:**', '').strip()
            parsing_steps = False
            parsing_brief_description = False
        elif line_stripped.startswith('**Шаги:**'):
            current_case['Этапы теста'] = ''
            parsing_steps = True
            parsing_brief_description = False
        elif line_stripped.startswith('**Ожидаемый результат:**'):
            current_case['Ожидаемый результат'] = line_stripped.replace('**Ожидаемый результат:**', '').strip()
            parsing_steps = False
            parsing_brief_description = False
        elif line_stripped and not parsing_steps and not line_stripped.startswith('**') and not re.match(r'^\\d+\\.\'', line_stripped) and not line_stripped.startswith('-'):
            if not current_case['Заголовок/название теста'] == '' and not current_case['Краткое изложение теста'] and not current_case['Предварительное условие'] and not current_case['Этапы теста'] and not parsing_brief_description:
                parsing_brief_description = True
                current_case['Краткое изложение теста'] = line_stripped
            elif parsing_brief_description:
                current_case['Краткое изложение теста'] += '\n' + line_stripped
        elif parsing_steps and line_stripped:
            if current_case['Этапы теста']:
                current_case['Этапы теста'] += '\n' + line_stripped
            else:
                current_case['Этапы теста'] = line_stripped
    
    if current_case.get('Тестовый пример #'):
        test_cases.append(current_case)
    
    return test_cases

def parse_sql_schema(sql_content):
    tables_data = []
    
    table_pattern = re.compile(r'CREATE TABLE IF NOT EXISTS public\.(\w+)\s*\((.*?)\);', re.DOTALL)
    
    fk_pattern = re.compile(r'ALTER TABLE IF EXISTS public\.(\w+)\s+ADD CONSTRAINT \w+\s+FOREIGN KEY \((.*?)\)\s+REFERENCES public\.(\w+)\s+\((.*?)\)', re.DOTALL)
    
    foreign_keys = {}
    for match in fk_pattern.finditer(sql_content):
        source_table, source_columns_str, target_table, target_columns_str = match.groups()
        source_columns = [col.strip().replace('"', '') for col in source_columns_str.split(',')]
        target_columns = [col.strip().replace('"', '') for col in target_columns_str.split(',')]
        
        for i, col in enumerate(source_columns):
            if source_table not in foreign_keys:
                foreign_keys[source_table] = []
            foreign_keys[source_table].append((col, target_table, target_columns[i] if i < len(target_columns) else 'id'))

    for table_match in table_pattern.finditer(sql_content):
        table_name = table_match.group(1)
        columns_and_constraints_str = table_match.group(2)
        lines = [line.strip() for line in columns_and_constraints_str.split('\n') if line.strip()]

        pk_columns = []
        unique_columns = {}

        for line in lines:
            pk_match = re.search(r'CONSTRAINT \w+ PRIMARY KEY \((.*?)\)', line)
            if pk_match:
                pk_columns.extend([col.strip().replace('"', '') for col in pk_match.group(1).split(',')])
            elif re.match(r'"?(\w+)"?\s+.*PRIMARY KEY', line):
                col_name_match = re.match(r'"?(\w+)"?', line)
                if col_name_match and col_name_match.group(1) not in pk_columns:
                    pk_columns.append(col_name_match.group(1))

            unique_match = re.search(r'CONSTRAINT \w+ UNIQUE \((.*?)\)', line)
            if unique_match:
                cols_in_unique = [col.strip().replace('"', '') for col in unique_match.group(1).split(',')]
                for col in cols_in_unique:
                    if col not in unique_columns:
                        unique_columns[col] = []
                    if 'CONSTRAINT_UNIQUE' not in unique_columns[col]:
                        unique_columns[col].append('CONSTRAINT_UNIQUE')
            elif re.match(r'"?(\w+)"?\s+.*UNIQUE', line):
                col_name_match = re.match(r'"?(\w+)"?', line)
                if col_name_match:
                    col_name = col_name_match.group(1)
                    if col_name not in unique_columns:
                        unique_columns[col_name] = []
                    if 'INLINE_UNIQUE' not in unique_columns[col_name]:
                        unique_columns[col_name].append('INLINE_UNIQUE')

        for line in lines:
            if line.startswith('CONSTRAINT'):
                continue

            parts = [p.strip() for p in line.split()]
            if not parts:
                continue

            col_name = parts[0].replace('"', '')
            
            col_type_parts = []
            nullability = 'NULL'
            for i in range(1, len(parts)):
                part = parts[i]
                if part.upper() == 'NOT' and i + 1 < len(parts) and parts[i+1].upper() == 'NULL':
                    nullability = 'NOT NULL'
                    break
                elif part.upper() == 'NULL':
                    nullability = 'NULL'
                    break
                elif part.upper() == 'DEFAULT':
                    break
                elif part.upper() == 'COLLATE':
                    col_type_parts.append(parts[i])
                    if i + 1 < len(parts):
                        col_type_parts.append(parts[i+1].replace(',', ''))
                    break
                
                col_type_parts.append(part.replace(',', ''))

            col_type = ' '.join(col_type_parts)

            constraints_for_col = []
            if col_name in pk_columns:
                constraints_for_col.append('PK')
            if col_name in unique_columns and (len(unique_columns[col_name]) > 0):
                if 'UNIQUE' not in constraints_for_col:
                    constraints_for_col.append('UNIQUE')

            if table_name in foreign_keys:
                for fk_col, fk_target_table, fk_target_col in foreign_keys[table_name]:
                    if fk_col == col_name:
                        constraints_for_col.append(f'FK ({fk_target_table}.{fk_target_col})')
            
            if not col_name:
                continue

            tables_data.append({
                'Таблица': table_name,
                'Название': col_name,
                'Тип': col_type,
                'NULL/NOT NULL': nullability,
                'Ограничения PK/FK': ', '.join(constraints_for_col) if constraints_for_col else ''
            })

    print("Tables data before DataFrame creation:", tables_data)

    if not tables_data:
        return pd.DataFrame(columns=['Таблица', 'Название', 'Тип', 'NULL/NOT NULL', 'Ограничения PK/FK'])

    return pd.DataFrame(tables_data)

sql_schema = """
-- This script was generated by the ERD tool in pgAdmin 4.
-- Please log an issue at https://github.com/pgadmin-org/pgadmin4/issues/new/choose if you find any bugs, including reproduction steps.
BEGIN;

CREATE TABLE IF NOT EXISTS public.cache
(
    key character varying(255) COLLATE pg_catalog."default" NOT NULL,
    value text COLLATE pg_catalog."default" NOT NULL,
    expiration integer NOT NULL,
    CONSTRAINT cache_pkey PRIMARY KEY (key)
);

CREATE TABLE IF NOT EXISTS public.cache_locks
(
    key character varying(255) COLLATE pg_catalog."default" NOT NULL,
    owner character varying(255) COLLATE pg_catalog."default" NOT NULL,
    expiration integer NOT NULL,
    CONSTRAINT cache_locks_pkey PRIMARY KEY (key)
);

CREATE TABLE IF NOT EXISTS public.car_brands
(
    id bigserial NOT NULL,
    name character varying(255) COLLATE pg_catalog."default" NOT NULL,
    description text COLLATE pg_catalog."default",
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT car_brands_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.car_car_option
(
    id bigserial NOT NULL,
    car_id bigint NOT NULL,
    car_option_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT car_car_option_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.car_models
(
    id bigserial NOT NULL,
    brand_id bigint NOT NULL,
    name character varying(255) COLLATE pg_catalog."default" NOT NULL,
    color character varying(255) COLLATE pg_catalog."default" NOT NULL,
    seats integer NOT NULL,
    trunk_volume numeric(5, 2) NOT NULL,
    horsepower integer NOT NULL,
    engine_volume numeric(4, 2) NOT NULL,
    fuel_type character varying(255) COLLATE pg_catalog."default" NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT car_models_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.car_options
(
    id bigserial NOT NULL,
    name character varying(100) COLLATE pg_catalog."default" NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT car_options_pkey PRIMARY KEY (id),
    CONSTRAINT car_options_name_unique UNIQUE (name)
);

CREATE TABLE IF NOT EXISTS public.car_product_types
(
    id bigserial NOT NULL,
    name character varying(255) COLLATE pg_catalog."default" NOT NULL,
    description text COLLATE pg_catalog."default",
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT car_product_types_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.car_products
(
    id bigserial NOT NULL,
    type_id bigint NOT NULL,
    name character varying(255) COLLATE pg_catalog."default" NOT NULL,
    description text COLLATE pg_catalog."default",
    price numeric(10, 2) NOT NULL,
    quantity integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT car_products_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.car_statuses
(
    id bigserial NOT NULL,
    name character varying(100) COLLATE pg_catalog."default" NOT NULL,
    description text COLLATE pg_catalog."default",
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT car_statuses_pkey PRIMARY KEY (id),
    CONSTRAINT car_statuses_name_unique UNIQUE (name)
);

CREATE TABLE IF NOT EXISTS public.cars
(
    id bigserial NOT NULL,
    salon_id bigint NOT NULL,
    brand_id bigint NOT NULL,
    model_id bigint NOT NULL,
    status_id bigint NOT NULL,
    vin character varying(255) COLLATE pg_catalog."default" NOT NULL,
    registration_number character varying(255) COLLATE pg_catalog."default" NOT NULL,
    year integer NOT NULL,
    price numeric(12, 2) NOT NULL,
    mileage numeric(10, 2) NOT NULL,
    description text COLLATE pg_catalog."default",
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT cars_pkey PRIMARY KEY (id),
    CONSTRAINT cars_registration_number_unique UNIQUE (registration_number),
    CONSTRAINT cars_vin_unique UNIQUE (vin)
);

CREATE TABLE IF NOT EXISTS public.clients
(
    id bigserial NOT NULL,
    last_name character varying(255) COLLATE pg_catalog."default" NOT NULL,
    first_name character varying(255) COLLATE pg_catalog."default" NOT NULL,
    middle_name character varying(255) COLLATE pg_catalog."default",
    passport character varying(255) COLLATE pg_catalog."default" NOT NULL,
    phone character varying(255) COLLATE pg_catalog."default" NOT NULL,
    email character varying(255) COLLATE pg_catalog."default" NOT NULL,
    password character varying(255) COLLATE pg_catalog."default" NOT NULL,
    address character varying(255) COLLATE pg_catalog."default" NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT clients_pkey PRIMARY KEY (id),
    CONSTRAINT clients_email_unique UNIQUE (email)
);

CREATE TABLE IF NOT EXISTS public.consultation_requests
(
    id bigserial NOT NULL,
    user_id bigint NOT NULL,
    employee_id bigint,
    status character varying(255) COLLATE pg_catalog."default" NOT NULL DEFAULT 'pending'::character varying,
    notes text COLLATE pg_catalog."default",
    scheduled_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    car_id bigint,
    CONSTRAINT consultation_requests_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.deals
(
    id bigserial NOT NULL,
    car_id bigint NOT NULL,
    client_id bigint NOT NULL,
    employee_id bigint NOT NULL,
    date date NOT NULL,
    amount numeric(12, 2) NOT NULL,
    type character varying(255) COLLATE pg_catalog."default" NOT NULL,
    description text COLLATE pg_catalog."default",
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT deals_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.employees
(
    id bigserial NOT NULL,
    salon_id bigint NOT NULL,
    job_title_id bigint NOT NULL,
    last_name character varying(255) COLLATE pg_catalog."default" NOT NULL,
    first_name character varying(255) COLLATE pg_catalog."default" NOT NULL,
    middle_name character varying(255) COLLATE pg_catalog."default",
    phone character varying(255) COLLATE pg_catalog."default" NOT NULL,
    email character varying(255) COLLATE pg_catalog."default" NOT NULL,
    password character varying(255) COLLATE pg_catalog."default" NOT NULL,
    salary numeric(10, 2),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT employees_pkey PRIMARY KEY (id),
    CONSTRAINT employees_email_unique UNIQUE (email)
);

CREATE TABLE IF NOT EXISTS public.failed_jobs
(
    id bigserial NOT NULL,
    uuid character varying(255) COLLATE pg_catalog."default" NOT NULL,
    connection text COLLATE pg_catalog."default" NOT NULL,
    queue text COLLATE pg_catalog."default" NOT NULL,
    payload text COLLATE pg_catalog."default" NOT NULL,
    exception text COLLATE pg_catalog."default" NOT NULL,
    failed_at timestamp(0) without time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT failed_jobs_pkey PRIMARY KEY (id),
    CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid)
);

CREATE TABLE IF NOT EXISTS public.job_batches
(
    id character varying(255) COLLATE pg_catalog."default" NOT NULL,
    name character varying(255) COLLATE pg_catalog."default" NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text COLLATE pg_catalog."default" NOT NULL,
    options text COLLATE pg_catalog."default",
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer,
    CONSTRAINT job_batches_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.job_titles
(
    id bigserial NOT NULL,
    title character varying(255) COLLATE pg_catalog."default" NOT NULL,
    description text COLLATE pg_catalog."default",
    daily_salary numeric(10, 2) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT job_titles_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.jobs
(
    id bigserial NOT NULL,
    queue character varying(255) COLLATE pg_catalog."default" NOT NULL,
    payload text COLLATE pg_catalog."default" NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL,
    CONSTRAINT jobs_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.migrations
(
    id serial NOT NULL,
    migration character varying(255) COLLATE pg_catalog."default" NOT NULL,
    batch integer NOT NULL,
    CONSTRAINT migrations_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.password_reset_tokens
(
    email character varying(255) COLLATE pg_catalog."default" NOT NULL,
    token character varying(255) COLLATE pg_catalog."default" NOT NULL,
    created_at timestamp(0) without time zone,
    CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email)
);

CREATE TABLE IF NOT EXISTS public.premiums
(
    id bigserial NOT NULL,
    employee_id bigint NOT NULL,
    payment_date date NOT NULL,
    amount numeric(10, 2) NOT NULL,
    description text COLLATE pg_catalog."default",
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT premiums_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.repair_works
(
    id bigserial NOT NULL,
    car_id bigint NOT NULL,
    employee_id bigint NOT NULL,
    start_date date NOT NULL,
    end_date date,
    status character varying(255) COLLATE pg_catalog."default" NOT NULL,
    cost numeric(10, 2) NOT NULL,
    description text COLLATE pg_catalog."default" NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT repair_works_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.salaries
(
    id bigserial NOT NULL,
    employee_id bigint NOT NULL,
    payment_date date NOT NULL,
    amount numeric(10, 2) NOT NULL,
    description text COLLATE pg_catalog."default",
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT salaries_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.salons
(
    id bigserial NOT NULL,
    name character varying(255) COLLATE pg_catalog."default" NOT NULL,
    address character varying(255) COLLATE pg_catalog."default" NOT NULL,
    phone character varying(255) COLLATE pg_catalog."default" NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT salons_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.sessions
(
    id character varying(255) COLLATE pg_catalog."default" NOT NULL,
    user_id bigint,
    ip_address character varying(45) COLLATE pg_catalog."default",
    user_agent text COLLATE pg_catalog."default",
    payload text COLLATE pg_catalog."default" NOT NULL,
    last_activity integer NOT NULL,
    CONSTRAINT sessions_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.users
(
    id bigserial NOT NULL,
    name character varying(255) COLLATE pg_catalog."default" NOT NULL,
    email character varying(255) COLLATE pg_catalog."default" NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) COLLATE pg_catalog."default" NOT NULL,
    remember_token character varying(100) COLLATE pg_catalog."default",
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT users_pkey PRIMARY KEY (id),
    CONSTRAINT users_email_unique UNIQUE (email)
);

ALTER TABLE IF EXISTS public.car_car_option
    ADD CONSTRAINT car_car_option_car_id_foreign FOREIGN KEY (car_id)
    REFERENCES public.cars (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE CASCADE;

ALTER TABLE IF EXISTS public.car_car_option
    ADD CONSTRAINT car_car_option_car_option_id_foreign FOREIGN KEY (car_option_id)
    REFERENCES public.car_options (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE CASCADE;

ALTER TABLE IF EXISTS public.car_models
    ADD CONSTRAINT car_models_brand_id_foreign FOREIGN KEY (brand_id)
    REFERENCES public.car_brands (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE CASCADE;

ALTER TABLE IF EXISTS public.car_products
    ADD CONSTRAINT car_products_type_id_foreign FOREIGN KEY (type_id)
    REFERENCES public.car_product_types (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE CASCADE;

ALTER TABLE IF EXISTS public.cars
    ADD CONSTRAINT cars_brand_id_foreign FOREIGN KEY (brand_id)
    REFERENCES public.car_brands (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE CASCADE;

ALTER TABLE IF EXISTS public.cars
    ADD CONSTRAINT cars_model_id_foreign FOREIGN KEY (model_id)
    REFERENCES public.car_models (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE CASCADE;

ALTER TABLE IF EXISTS public.cars
    ADD CONSTRAINT cars_salon_id_foreign FOREIGN KEY (salon_id)
    REFERENCES public.salons (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE CASCADE;

ALTER TABLE IF EXISTS public.cars
    ADD CONSTRAINT cars_status_id_foreign FOREIGN KEY (status_id)
    REFERENCES public.car_statuses (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE CASCADE;


ALTER TABLE IF EXISTS public.consultation_requests
    ADD CONSTRAINT consultation_requests_car_id_foreign FOREIGN KEY (car_id)
    REFERENCES public.cars (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE SET NULL;


ALTER TABLE IF EXISTS public.consultation_requests
    ADD CONSTRAINT consultation_requests_employee_id_foreign FOREIGN KEY (employee_id)
    REFERENCES public.employees (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE SET NULL;


ALTER TABLE IF EXISTS public.consultation_requests
    ADD CONSTRAINT consultation_requests_user_id_foreign FOREIGN KEY (user_id)
    REFERENCES public.clients (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE CASCADE;


ALTER TABLE IF EXISTS public.deals
    ADD CONSTRAINT deals_car_id_foreign FOREIGN KEY (car_id)
    REFERENCES public.cars (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE CASCADE;


ALTER TABLE IF EXISTS public.deals
    ADD CONSTRAINT deals_client_id_foreign FOREIGN KEY (client_id)
    REFERENCES public.clients (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE CASCADE;


ALTER TABLE IF EXISTS public.deals
    ADD CONSTRAINT deals_employee_id_foreign FOREIGN KEY (employee_id)
    REFERENCES public.employees (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE CASCADE;


ALTER TABLE IF EXISTS public.employees
    ADD CONSTRAINT employees_job_title_id_foreign FOREIGN KEY (job_title_id)
    REFERENCES public.job_titles (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE CASCADE;


ALTER TABLE IF EXISTS public.employees
    ADD CONSTRAINT employees_salon_id_foreign FOREIGN KEY (salon_id)
    REFERENCES public.salons (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE CASCADE;


ALTER TABLE IF EXISTS public.premiums
    ADD CONSTRAINT premiums_employee_id_foreign FOREIGN KEY (employee_id)
    REFERENCES public.employees (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE CASCADE;


ALTER TABLE IF EXISTS public.repair_works
    ADD CONSTRAINT repair_works_car_id_foreign FOREIGN KEY (car_id)
    REFERENCES public.cars (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE CASCADE;


ALTER TABLE IF EXISTS public.repair_works
    ADD CONSTRAINT repair_works_employee_id_foreign FOREIGN KEY (employee_id)
    REFERENCES public.employees (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE CASCADE;


ALTER TABLE IF EXISTS public.salaries
    ADD CONSTRAINT salaries_employee_id_foreign FOREIGN KEY (employee_id)
    REFERENCES public.employees (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE CASCADE;

END;
"""

db_dict_df = parse_sql_schema(sql_schema)

# Write all tables to a single sheet
with pd.ExcelWriter('docs/database_dictionary.xlsx', engine='openpyxl') as writer:
    if not db_dict_df.empty:
        db_dict_df[['Таблица', 'Название', 'Тип', 'NULL/NOT NULL', 'Ограничения PK/FK']].to_excel(writer, sheet_name='Словарь БД', index=False)
    else:
        pd.DataFrame(columns=['Таблица', 'Название', 'Тип', 'NULL/NOT NULL', 'Ограничения PK/FK']).to_excel(writer, sheet_name='Словарь БД', index=False)

# Re-reading and converting test cases (updated logic)
with open('docs/test_cases.md', 'r', encoding='utf-8') as f:
    test_cases_content = f.read()

parsed_test_cases = parse_test_cases(test_cases_content)

# Define the order of parameters for the vertical table based on the image
test_case_parameter_order = [
    'Тестовый пример #',
    'Приоритет тестирования',
    'Заголовок/название теста',
    'Краткое изложение теста',
    'Этапы теста',
    'Тестовые данные',
    'Ожидаемый результат',
    'Фактический результат',
    'Статус',
    'Предварительное условие',
    'Постусловие',
    'Примечания/комментарии'
]

# Write test cases to a single sheet, each as a separate vertical table
with pd.ExcelWriter('docs/test_cases.xlsx', engine='openpyxl') as writer:
    start_row = 0
    sheet_name = 'Тест-кейсы'

    if not parsed_test_cases:
        # If no test cases parsed, create an empty table with headers
        empty_df_for_headers = pd.DataFrame([['Параметр', 'Значение']], columns=['Параметр', 'Значение'])
        empty_df_for_headers.to_excel(writer, sheet_name=sheet_name, index=False, header=False, startrow=start_row)
        start_row += 1
    else:
        for tc_index, test_case_dict in enumerate(parsed_test_cases):
            current_tc_rows = []
            for param in test_case_parameter_order:
                value = test_case_dict.get(param, '')
                current_tc_rows.append([param, value])
            
            current_tc_df = pd.DataFrame(current_tc_rows, columns=['Параметр', 'Значение'])

            current_tc_df.to_excel(writer, sheet_name=sheet_name, startrow=start_row, index=False, header=False)

            # Add empty rows for separation between test cases
            start_row += len(current_tc_rows) + 2
