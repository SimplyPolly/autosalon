@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Добавить модель автомобиля</h2>
    <form action="{{ route('admin.car-models.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Модель</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Цвет</label>
            <input type="text" name="color" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Количество мест</label>
            <input type="number" name="seats" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Объем багажника</label>
            <input type="number" name="trunk_volume" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Количество лс</label>
            <input type="number" name="horsepower" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Объем двигателя</label>
            <input type="number" name="engine_volume" class="form-control" step="0.01">
        </div>
        <div class="mb-3">
            <label class="form-label">Тип топлива</label>
            <input type="text" name="fuel_type" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Сохранить</button>
        <a href="{{ route('admin.car-models.index') }}" class="btn btn-secondary">Назад</a>
    </form>
</div>
@endsection 