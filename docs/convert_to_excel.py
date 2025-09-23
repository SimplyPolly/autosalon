import pandas as pd
import re

def parse_test_cases(md_content):
    test_cases = []
    current_case = {}
    
    for line in md_content.split('\n'):
        if line.startswith('### TC-'):
            if current_case:
                test_cases.append(current_case)
            current_case = {
                'ID': line.split(':')[0].replace('### ', ''),
                'Название': line.split(':')[1].strip(),
                'Предусловие': '',
                'Шаги': '',
                'Ожидаемый результат': ''
            }
        elif line.startswith('**Предусловие:**'):
            current_case['Предусловие'] = line.replace('**Предусловие:**', '').strip()
        elif line.startswith('**Шаги:**'):
            current_case['Шаги'] = ''
        elif line.startswith('**Ожидаемый результат:**'):
            current_case['Ожидаемый результат'] = line.replace('**Ожидаемый результат:**', '').strip()
        elif line.strip() and current_case.get('Шаги') == '':
            current_case['Шаги'] = line.strip()
        elif line.strip() and current_case.get('Шаги'):
            current_case['Шаги'] += '\n' + line.strip()
    
    if current_case:
        test_cases.append(current_case)
    
    return pd.DataFrame(test_cases)

def parse_database_dict(md_content):
    tables = []
    current_table = {}
    
    for line in md_content.split('\n'):
        if line.startswith('### '):
            if current_table:
                tables.append(current_table)
            current_table = {
                'Таблица': line.replace('### ', '').strip(),
                'Описание': '',
                'Поля': ''
            }
        elif line.startswith('- Описание:'):
            current_table['Описание'] = line.replace('- Описание:', '').strip()
        elif line.startswith('  - '):
            if current_table.get('Поля'):
                current_table['Поля'] += '\n' + line.strip()
            else:
                current_table['Поля'] = line.strip()
    
    if current_table:
        tables.append(current_table)
    
    return pd.DataFrame(tables)

# Чтение и конвертация тест-кейсов
with open('test_cases.md', 'r', encoding='utf-8') as f:
    test_cases_content = f.read()
test_cases_df = parse_test_cases(test_cases_content)
test_cases_df.to_excel('test_cases.xlsx', index=False)

# Чтение и конвертация словаря БД
with open('database_dictionary.md', 'r', encoding='utf-8') as f:
    db_dict_content = f.read()
db_dict_df = parse_database_dict(db_dict_content)
db_dict_df.to_excel('database_dictionary.xlsx', index=False) 