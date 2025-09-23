@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Добавить тип автотовара</h2>
    <form action="{{ route('admin.car-product-types.store', $type) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Название типа</label>
            <input type="text" name="Название_типа" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Сохранить</button>
        <a href="{{ route('admin.car-product-types.index', $type) }}" class="btn btn-secondary">Назад</a>
    </form>
</div>
@endsection 