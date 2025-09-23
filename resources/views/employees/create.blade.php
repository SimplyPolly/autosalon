@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Добавление сотрудника</h2>
    <form action="{{ route('admin.employees.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Имя</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="phone">Телефон</label>
            <input type="tel" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
            @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="position_id">Должность</label>
            <select name="position_id" id="position_id" class="form-control @error('position_id') is-invalid @enderror">
                <option value="">Выберите должность</option>
                @foreach ($positions as $position)
                <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                    {{ $position->name }}
                </option>
                @endforeach
            </select>
            @error('position_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Подтверждение пароля</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>
@endsection 