@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Редактирование записи о зарплате</h2>

    <form action="{{ route('admin.salaries.update', $salary) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="employee_id" class="form-label">Сотрудник</label>
            <select name="employee_id" id="employee_id" class="form-select @error('employee_id') is-invalid @enderror" required>
                <option value="">Выберите сотрудника</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" {{ (old('employee_id', $salary->employee_id) == $employee->id) ? 'selected' : '' }}>
                        {{ $employee->name }} ({{ $employee->role->name }})
                    </option>
                @endforeach
            </select>
            @error('employee_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="month" class="form-label">Месяц</label>
            <select name="month" id="month" class="form-select @error('month') is-invalid @enderror" required>
                <option value="">Выберите месяц</option>
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ (old('month', $salary->month) == $m) ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                    </option>
                @endforeach
            </select>
            @error('month')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="year" class="form-label">Год</label>
            <select name="year" id="year" class="form-select @error('year') is-invalid @enderror" required>
                <option value="">Выберите год</option>
                @foreach(range(date('Y')-1, date('Y')+1) as $y)
                    <option value="{{ $y }}" {{ (old('year', $salary->year) == $y) ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endforeach
            </select>
            @error('year')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="base_salary" class="form-label">Базовая ставка</label>
            <input type="number" step="0.01" name="base_salary" id="base_salary" class="form-control @error('base_salary') is-invalid @enderror" value="{{ old('base_salary', $salary->base_salary) }}" required>
            @error('base_salary')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="premium" class="form-label">Премия</label>
            <input type="number" step="0.01" name="premium" id="premium" class="form-control @error('premium') is-invalid @enderror" value="{{ old('premium', $salary->premium) }}" required>
            @error('premium')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            <a href="{{ route('admin.salaries.index') }}" class="btn btn-secondary">Отмена</a>
        </div>
    </form>
</div>
@endsection 