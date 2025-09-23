@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Редактирование модели автомобиля</h2>
    <form action="{{ route('admin.car-models.update', $model->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="brand_id">Марка</label>
            <select name="brand_id" id="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                <option value="">Выберите марку</option>
                @foreach ($brands as $brand)
                <option value="{{ $brand->id }}" {{ (old('brand_id', $model->brand_id) == $brand->id) ? 'selected' : '' }}>
                    {{ $brand->name }}
                </option>
                @endforeach
            </select>
            @error('brand_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="name">Название</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $model->name) }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="color">Цвет</label>
            <input type="text" name="color" id="color" class="form-control @error('color') is-invalid @enderror" value="{{ old('color', $model->color) }}">
            @error('color')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="seats">Количество мест</label>
            <input type="number" name="seats" id="seats" class="form-control @error('seats') is-invalid @enderror" value="{{ old('seats', $model->seats) }}">
            @error('seats')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="trunk_volume">Объем багажника (л)</label>
            <input type="number" step="0.1" name="trunk_volume" id="trunk_volume" class="form-control @error('trunk_volume') is-invalid @enderror" value="{{ old('trunk_volume', $model->trunk_volume) }}">
            @error('trunk_volume')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="horsepower">Количество лошадиных сил</label>
            <input type="number" name="horsepower" id="horsepower" class="form-control @error('horsepower') is-invalid @enderror" value="{{ old('horsepower', $model->horsepower) }}">
            @error('horsepower')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="engine_volume">Объем двигателя (л)</label>
            <input type="number" step="0.1" name="engine_volume" id="engine_volume" class="form-control @error('engine_volume') is-invalid @enderror" value="{{ old('engine_volume', $model->engine_volume) }}">
            @error('engine_volume')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="fuel_type">Тип топлива</label>
            <select name="fuel_type" id="fuel_type" class="form-control @error('fuel_type') is-invalid @enderror">
                <option value="">Выберите тип топлива</option>
                <option value="Бензин" {{ (old('fuel_type', $model->fuel_type) == 'Бензин') ? 'selected' : '' }}>Бензин</option>
                <option value="Дизель" {{ (old('fuel_type', $model->fuel_type) == 'Дизель') ? 'selected' : '' }}>Дизель</option>
                <option value="Газ" {{ (old('fuel_type', $model->fuel_type) == 'Газ') ? 'selected' : '' }}>Газ</option>
                <option value="Электро" {{ (old('fuel_type', $model->fuel_type) == 'Электро') ? 'selected' : '' }}>Электро</option>
                <option value="Гибрид" {{ (old('fuel_type', $model->fuel_type) == 'Гибрид') ? 'selected' : '' }}>Гибрид</option>
            </select>
            @error('fuel_type')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        <a href="{{ route('admin.car-models.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>
@endsection 