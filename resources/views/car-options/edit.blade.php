@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Редактировать опцию автомобиля</h2>
    <form action="{{ route('admin.car-options.update', $carOption->ID_опции) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Название опции</label>
            <input type="text" name="Название_опции" class="form-control" value="{{ $carOption->Название_опции }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Описание опции</label>
            <textarea name="Описание_опции" class="form-control">{{ $carOption->Описание_опции }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Стоимость опции</label>
            <input type="number" name="Стоимость_опции" class="form-control" step="0.01" value="{{ $carOption->Стоимость_опции }}">
        </div>
        <button type="submit" class="btn btn-success">Обновить</button>
        <a href="{{ route('admin.car-options.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>
@endsection 