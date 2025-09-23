@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Детали модели автомобиля</h2>
    <div class="card mb-4">
        <div class="card-header">
            <h3>Основная информация</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>ID:</strong> {{ $model->id }}</p>
                    <p><strong>Марка:</strong> {{ $model->brand->name }}</p>
                    <p><strong>Название:</strong> {{ $model->name }}</p>
                    <p><strong>Цвет:</strong> {{ $model->color }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Количество мест:</strong> {{ $model->seats }}</p>
                    <p><strong>Объем багажника:</strong> {{ $model->trunk_volume }} л</p>
                    <p><strong>Количество лошадиных сил:</strong> {{ $model->horsepower }}</p>
                    <p><strong>Объем двигателя:</strong> {{ $model->engine_volume }} л</p>
                    <p><strong>Тип топлива:</strong> {{ $model->fuel_type }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($model->cars->count() > 0)
    <div class="card mb-4">
        <div class="card-header">
            <h3>Автомобили этой модели</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Год выпуска</th>
                            <th>Цена</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($model->cars as $car)
                        <tr>
                            <td>{{ $car->id }}</td>
                            <td>{{ $car->year }}</td>
                            <td>{{ number_format($car->price, 2) }} ₽</td>
                            <td>{{ $car->status->name }}</td>
                            <td>
                                <a href="{{ route('admin.cars.show', $car->id) }}" class="btn btn-sm btn-info">Просмотр</a>
                                <a href="{{ route('admin.cars.edit', $car->id) }}" class="btn btn-sm btn-primary">Редактировать</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('admin.car-models.index') }}" class="btn btn-secondary">К списку моделей</a>
        <a href="{{ route('admin.car-models.edit', $model->id) }}" class="btn btn-primary">Редактировать</a>
        <form action="{{ route('admin.car-models.destroy', $model->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить эту модель?')">Удалить</button>
        </form>
    </div>
</div>
@endsection 