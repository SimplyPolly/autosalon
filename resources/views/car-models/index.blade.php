@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Модели автомобилей</h2>
    <a href="{{ route('admin.car-models.create') }}" class="btn btn-primary mb-3">Добавить модель</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if ($models->count())
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Марка</th>
                <th>Название</th>
                <th>Цвет</th>
                <th>Количество мест</th>
                <th>Объем багажника</th>
                <th>Количество лс</th>
                <th>Объем двигателя</th>
                <th>Тип топлива</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($models as $model)
            <tr>
                <td>{{ $model->id }}</td>
                <td>{{ $model->brand->name }}</td>
                <td>{{ $model->name }}</td>
                <td>{{ $model->color }}</td>
                <td>{{ $model->seats }}</td>
                <td>{{ $model->trunk_volume }} л</td>
                <td>{{ $model->horsepower }} л.с.</td>
                <td>{{ $model->engine_volume }} л</td>
                <td>{{ $model->fuel_type }}</td>
                <td>
                    <a href="{{ route('admin.car-models.show', $model) }}" class="btn btn-info btn-sm">Просмотр</a>
                    <a href="{{ route('admin.car-models.edit', $model) }}" class="btn btn-warning btn-sm">Редактировать</a>
                    <form action="{{ route('admin.car-models.destroy', $model) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены, что хотите удалить?')">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $models->links() }}
    @else
    <p>Нет данных.</p>
    @endif
</div>
@endsection 