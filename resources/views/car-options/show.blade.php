@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Детали опции автомобиля: {{ $carOption->Название_опции }}</h2>
    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $carOption->ID_опции }}</p>
            <p><strong>Название опции:</strong> {{ $carOption->Название_опции }}</p>
            <p><strong>Описание опции:</strong> {{ $carOption->Описание_опции ?? 'N/A' }}</p>
            <p><strong>Стоимость опции:</strong> {{ $carOption->Стоимость_опции ?? 'N/A' }}</p>
        </div>
    </div>
    <a href="{{ route('admin.car-options.index') }}" class="btn btn-secondary mt-3">К списку опций</a>
    @auth('employee')
        @if(Auth::guard('employee')->user()->role->Название_должности === 'Администратор')
            <a href="{{ route('admin.car-options.edit', $carOption->ID_опции) }}" class="btn btn-warning mt-3">Редактировать</a>
        @endif
    @endauth
</div>
@endsection 