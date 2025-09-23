@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Редактировать тип автотовара</h2>
    <form action="{{ route('admin.car-product-types.update', $type) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Название типа</label>
            <input type="text" name="Название_типа" class="form-control" value="{{ $carProductType->Название_типа }}" required>
        </div>
        <button type="submit" class="btn btn-success">Обновить</button>
        <a href="{{ route('admin.car-product-types.index', $type) }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>
@endsection