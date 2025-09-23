@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Редактирование должности</h2>
    <form action="{{ route('admin.positions.update', $position) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Название</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $position->name) }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Описание</label>
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $position->description) }}</textarea>
            @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        <a href="{{ route('admin.positions.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>
@endsection 