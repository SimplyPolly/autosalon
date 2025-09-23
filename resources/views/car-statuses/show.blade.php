@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Детали статуса автомобиля: {{ $carStatus->Статус_автомобиля }}</h2>
    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $carStatus->ID_статуса_автомобиля }}</p>
            <p><strong>Статус:</strong> {{ $carStatus->Статус_автомобиля }}</p>
        </div>
    </div>
    <a href="{{ route('admin.car-statuses.index') }}" class="btn btn-secondary mt-3">К списку статусов</a>
    @auth('employee')
        @if(Auth::guard('employee')->user()->role->Название_должности === 'Администратор')
            <a href="{{ route('admin.car-statuses.edit', $carStatus->ID_статуса_автомобиля) }}" class="btn btn-warning mt-3">Редактировать</a>
        @endif
    @endauth
</div>
@endsection 