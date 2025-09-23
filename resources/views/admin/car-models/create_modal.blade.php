@extends('layouts.app')

@section('content')
<form id="createModelForm" method="POST" action="{{ route('admin.car-models.store') }}">
    @csrf
    <div class="mb-3">
        <label for="id_марки" class="form-label">Бренд</label>
        <select class="form-select" id="id_марки" name="id_марки" required>
            <option value="">Выберите бренд</option>
            @foreach($brands as $brand)
                <option value="{{ $brand->id_марки }}">{{ $brand->Название_марки }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="Название_модели" class="form-label">Название модели</label>
        <input type="text" class="form-control" id="Название_модели" name="Название_модели" required>
    </div>
    <div class="mb-3">
        <label for="Цвет" class="form-label">Цвет</label>
        <input type="text" class="form-control" id="Цвет" name="Цвет">
    </div>
    <div class="mb-3">
        <label for="Количество_мест" class="form-label">Количество мест</label>
        <input type="number" class="form-control" id="Количество_мест" name="Количество_мест" min="1">
    </div>
    <div class="mb-3">
        <label for="Объем_багажника" class="form-label">Объем багажника (л)</label>
        <input type="number" class="form-control" id="Объем_багажника" name="Объем_багажника" min="0">
    </div>
    <div class="mb-3">
        <label for="Количество_лс" class="form-label">Мощность (лс)</label>
        <input type="number" class="form-control" id="Количество_лс" name="Количество_лс" min="0">
    </div>
    <div class="mb-3">
        <label for="Объем_двигателя" class="form-label">Объем двигателя</label>
        <input type="number" class="form-control" id="Объем_двигателя" name="Объем_двигателя" step="0.01" min="0">
    </div>
    <div class="mb-3">
        <label for="Тип_топлива" class="form-label">Тип топлива</label>
        <input type="text" class="form-control" id="Тип_топлива" name="Тип_топлива">
    </div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>
@endsection 