@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Детали марки автомобиля</h2>
    <div class="card mb-4">
        <div class="card-header">
            <h3>Основная информация</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>ID марки:</strong> {{ $brand->id }}</p>
                    <p><strong>Название:</strong> {{ $brand->name }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Описание:</strong></p>
                    <p>{{ $brand->description }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Модели этой марки</h3>
        </div>
        <div class="card-body">
            @if ($brand->models->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Цвет</th>
                        <th>Количество мест</th>
                        <th>Объем багажника</th>
                        <th>Количество лс</th>
                        <th>Объем двигателя</th>
                        <th>Тип топлива</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($brand->models as $model)
                    <tr>
                        <td>{{ $model->id }}</td>
                        <td>{{ $model->name }}</td>
                        <td>{{ $model->color }}</td>
                        <td>{{ $model->seats }}</td>
                        <td>{{ $model->trunk_volume }} л</td>
                        <td>{{ $model->horsepower }} л.с.</td>
                        <td>{{ $model->engine_volume }} л</td>
                        <td>{{ $model->fuel_type }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>У этой марки нет моделей.</p>
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Автомобили этой марки</h3>
        </div>
        <div class="card-body">
            @if ($brand->cars->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Модель</th>
                        <th>Год выпуска</th>
                        <th>Цена</th>
                        <th>Статус</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($brand->cars as $car)
                    <tr>
                        <td>{{ $car->id }}</td>
                        <td>{{ $car->model->name }}</td>
                        <td>{{ $car->year }}</td>
                        <td>{{ number_format($car->price, 2) }} ₽</td>
                        <td>{{ $car->status->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>Нет автомобилей этой марки.</p>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.car-brands.index') }}" class="btn btn-secondary">К списку марок</a>
        <a href="{{ route('admin.car-brands.edit', $brand) }}" class="btn btn-warning">Редактировать</a>
        <form action="{{ route('admin.car-brands.destroy', $brand) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить?')">Удалить</button>
        </form>
    </div>
</div>
@endsection 