@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Информация о типе автотовара</h2>
    <p><strong>ID типа:</strong> {{ $carProductType->id_типа_товара }}</p>
    <p><strong>Название типа:</strong> {{ $carProductType->Название_типа }}</p>
    <p><strong>Описание:</strong> {{ $carProductType->Описание ?? 'Отсутствует' }}</p>

    <a href="{{ route('admin.car-product-types.edit', $carProductType) }}" class="btn btn-warning">Редактировать</a>

    <form action="{{ route('admin.car-product-types.destroy', $carProductType) }}" method="POST" style="display:inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить этот тип?')">Удалить</button>
    </form>

    <a href="{{ route('admin.car-product-types.index') }}" class="btn btn-secondary">Назад</a>
</div>
@endsection