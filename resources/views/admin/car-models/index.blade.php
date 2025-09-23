@extends('layouts.app')

@section('title', 'Каталог моделей автомобилей')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Каталог моделей автомобилей</h2>
        @auth('employee')
            @if($employee && $employee->jobTitle && $employee->jobTitle->title === 'Администратор')
                <a href="{{ route('admin.car-models.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Добавить модель
                </a>
            @endif
        @endauth
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Марка</th>
                <th>Название модели</th>
                <th>Цвет</th>
                <th>Мест</th>
                <th>Объем багажника</th>
                <th>ЛС</th>
                <th>Объем двигателя</th>
                <th>Тип топлива</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($models as $model)
                <tr>
                    <td>{{ $model->id }}</td>
                    <td>{{ $model->brand->name ?? '' }}</td>
                    <td>{{ $model->name }}</td>
                    <td>{{ $model->color }}</td>
                    <td>{{ $model->seats }}</td>
                    <td>{{ $model->trunk_volume }}</td>
                    <td>{{ $model->horsepower }}</td>
                    <td>{{ $model->engine_volume }}</td>
                    <td>{{ $model->fuel_type }}</td>
                    <td>
                        <a href="{{ route('admin.car-models.show', $model->id) }}" class="btn btn-info btn-sm">Подробнее</a>
                        @auth('employee')
                            @if($employee && $employee->jobTitle && $employee->jobTitle->title === 'Администратор')
                                <a href="{{ route('admin.car-models.edit', $model->id) }}" class="btn btn-primary btn-sm">Изменить</a>
                                <form action="{{ route('admin.car-models.destroy', $model->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены?')">Удалить</button>
                                </form>
                            @endif
                        @endauth
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 