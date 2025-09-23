@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Добавление премии</h2>
    <form action="{{ route('admin.premiums.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="employee_id">Сотрудник</label>
            <select name="employee_id" id="employee_id" class="form-control @error('employee_id') is-invalid @enderror">
                <option value="">Выберите сотрудника</option>
                @foreach ($employees as $employee)
                <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                    {{ $employee->name }} ({{ $employee->position->name }})
                </option>
                @endforeach
            </select>
            @error('employee_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="date">Дата</label>
            <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}">
            @error('date')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="amount">Сумма</label>
            <input type="number" step="0.01" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}">
            @error('amount')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="reason">Причина</label>
            <textarea name="reason" id="reason" class="form-control @error('reason') is-invalid @enderror" rows="3">{{ old('reason') }}</textarea>
            @error('reason')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ route('admin.premiums.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>
@endsection 