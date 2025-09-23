@extends('layouts.app')

@section('title', 'Детали модели автомобиля')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Детали модели автомобиля</h3>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $model->id }}</p>
            <p><strong>Марка:</strong> {{ $model->brand->name ?? '' }}</p>
            <p><strong>Название модели:</strong> {{ $model->name }}</p>
            <p><strong>Цвет:</strong> {{ $model->color }}</p>
            <p><strong>Количество мест:</strong> {{ $model->seats }}</p>
            <p><strong>Объем багажника:</strong> {{ $model->trunk_volume }}</p>
            <p><strong>Лошадиные силы:</strong> {{ $model->horsepower }}</p>
            <p><strong>Объем двигателя:</strong> {{ $model->engine_volume }}</p>
            <p><strong>Тип топлива:</strong> {{ $model->fuel_type }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.car-models.index') }}" class="btn btn-secondary">Назад к списку</a>
            @auth('employee')
                @if($employee && $employee->jobTitle && $employee->jobTitle->title === 'Администратор')
                    <a href="{{ route('admin.car-models.edit', $model->id) }}" class="btn btn-primary">Изменить</a>
                    <form action="{{ route('admin.car-models.destroy', $model->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены?')">Удалить</button>
                    </form>
                @endif
            @endauth
        </div>
    </div>
</div>
@endsection 