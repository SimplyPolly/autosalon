@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Добавление статуса</h2>
    <form action="{{ route('admin.statuses.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Название</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Описание</label>
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
            @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ route('admin.statuses.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>
@endsection 