@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Добавление ремонтной работы</h2>

    <form action="{{ route('admin.repair-works.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="car_id" class="form-label">Автомобиль</label>
            <select name="car_id" id="car_id" class="form-select @error('car_id') is-invalid @enderror" required>
                <option value="">Выберите автомобиль</option>
                @foreach($cars as $car)
                    <option value="{{ $car->id }}" {{ old('car_id') == $car->id ? 'selected' : '' }}>
                        {{ $car->brand->name }} {{ $car->model->name }} ({{ $car->year }})
                    </option>
                @endforeach
            </select>
            @error('car_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="employee_id" class="form-label">Сотрудник</label>
            <select name="employee_id" id="employee_id" class="form-select @error('employee_id') is-invalid @enderror" required>
                <option value="">Выберите сотрудника</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                        {{ $employee->name }}
                    </option>
                @endforeach
            </select>
            @error('employee_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Описание работ</label>
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Дата начала</label>
            <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', date('Y-m-d')) }}" required>
            @error('start_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="status_id" class="form-label">Статус</label>
            <select name="status_id" id="status_id" class="form-select @error('status_id') is-invalid @enderror" required>
                <option value="">Выберите статус</option>
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                        {{ $status->name }}
                    </option>
                @endforeach
            </select>
            @error('status_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="cost" class="form-label">Стоимость</label>
            <input type="number" step="0.01" name="cost" id="cost" class="form-control @error('cost') is-invalid @enderror" value="{{ old('cost') }}" required>
            @error('cost')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Создать</button>
            <a href="{{ route('admin.repair-works.index') }}" class="btn btn-secondary">Отмена</a>
        </div>
    </form>
</div>
@endsection 