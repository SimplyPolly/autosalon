@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Добавить опцию автомобиля</h2>
    <form action="{{ route('admin.car-options.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Название опции</label>
            <input type="text" name="Название_опции" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Описание опции</label>
            <textarea name="Описание_опции" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Стоимость опции</label>
            <input type="number" name="Стоимость_опции" class="form-control" step="0.01">
        </div>
        <button type="submit" class="btn btn-success">Сохранить</button>
        <a href="{{ route('admin.car-options.index') }}" class="btn btn-secondary">Назад</a>
    </form>
</div>
@endsection 