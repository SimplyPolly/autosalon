@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Детали статуса автомобиля</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Название:</strong> {{ $car_status->name }}</p>
                    <p><strong>Описание:</strong> {{ $car_status->description }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            @if($employee && $employee->jobTitle && $employee->jobTitle->title === 'Администратор')
                <a href="{{ route('admin.car-statuses.edit', $car_status->id) }}" class="btn btn-primary">Изменить</a>
                <form action="{{ route('admin.car-statuses.destroy', $car_status->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены?')">Удалить</button>
                </form>
            @endif
            <a href="{{ route('admin.car-statuses.index') }}" class="btn btn-secondary">Назад к списку</a>
        </div>
    </div>
</div>
@endsection 