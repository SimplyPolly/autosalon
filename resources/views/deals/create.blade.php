@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Создание новой сделки</h2>

    <form action="{{ route('admin.deals.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="car_id" class="form-label">Автомобиль</label>
            <select name="car_id" id="car_id" class="form-select @error('car_id') is-invalid @enderror" required>
                <option value="">Выберите автомобиль</option>
                @foreach($cars as $car)
                    <option value="{{ $car->id }}" {{ old('car_id') == $car->id ? 'selected' : '' }}>
                        {{ $car->brand->name }} {{ $car->model->name }} - {{ $car->price }} ₽
                    </option>
                @endforeach
            </select>
            @error('car_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="product_id" class="form-label">Товар (опционально)</label>
            <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror">
                <option value="">Выберите товар</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }} - {{ $product->price }} ₽
                    </option>
                @endforeach
            </select>
            @error('product_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="client_id" class="form-label">Клиент</label>
            <select name="client_id" id="client_id" class="form-select @error('client_id') is-invalid @enderror" required>
                <option value="">Выберите клиента</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                        {{ $client->name }}
                    </option>
                @endforeach
            </select>
            @error('client_id')
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
            <label for="deal_date" class="form-label">Дата сделки</label>
            <input type="date" name="deal_date" id="deal_date" class="form-control @error('deal_date') is-invalid @enderror" value="{{ old('deal_date', date('Y-m-d')) }}" required>
            @error('deal_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Сумма сделки</label>
            <input type="number" step="0.01" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}" required>
            @error('amount')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Создать сделку</button>
            <a href="{{ route('admin.deals.index') }}" class="btn btn-secondary">Отмена</a>
        </div>
    </form>
</div>
@endsection 