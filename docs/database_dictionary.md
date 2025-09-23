# Словарь базы данных автосалона

## 1. Таблицы и их описание

### users
- Описание: Пользователи системы
- Основные поля:
  - id: Уникальный идентификатор
  - name: Имя пользователя
  - email: Email пользователя
  - password: Хеш пароля
  - role: Роль пользователя

### cars
- Описание: Автомобили в салоне
- Основные поля:
  - id: Уникальный идентификатор
  - brand_id: ID марки
  - model_id: ID модели
  - year: Год выпуска
  - price: Цена
  - status_id: ID статуса
  - vin: VIN-номер

### car_brands
- Описание: Марки автомобилей
- Основные поля:
  - id: Уникальный идентификатор
  - name: Название марки

### car_models
- Описание: Модели автомобилей
- Основные поля:
  - id: Уникальный идентификатор
  - brand_id: ID марки
  - name: Название модели

### employees
- Описание: Сотрудники салона
- Основные поля:
  - id: Уникальный идентификатор
  - name: Имя сотрудника
  - position_id: ID должности
  - salary: Оклад
  - salon_id: ID салона

### deals
- Описание: Сделки по продаже
- Основные поля:
  - id: Уникальный идентификатор
  - car_id: ID автомобиля
  - client_id: ID клиента
  - employee_id: ID сотрудника
  - amount: Сумма сделки
  - date: Дата сделки

### salaries
- Описание: Зарплаты сотрудников
- Основные поля:
  - id: Уникальный идентификатор
  - employee_id: ID сотрудника
  - amount: Сумма
  - date: Дата выплаты

### premiums
- Описание: Премии сотрудников
- Основные поля:
  - id: Уникальный идентификатор
  - employee_id: ID сотрудника
  - amount: Сумма
  - date: Дата выплаты

## 2. Связи между таблицами

### Основные связи
- cars.brand_id -> car_brands.id
- cars.model_id -> car_models.id
- car_models.brand_id -> car_brands.id
- employees.position_id -> job_titles.id
- employees.salon_id -> salons.id
- deals.car_id -> cars.id
- deals.client_id -> clients.id
- deals.employee_id -> employees.id
- salaries.employee_id -> employees.id
- premiums.employee_id -> employees.id

## 3. Типы данных

### Основные типы
- id: bigint unsigned
- name: varchar(255)
- email: varchar(255)
- password: varchar(255)
- price: decimal(10,2)
- amount: decimal(10,2)
- date: date/datetime
- status: varchar(50)
- description: text
- created_at: timestamp
- updated_at: timestamp 