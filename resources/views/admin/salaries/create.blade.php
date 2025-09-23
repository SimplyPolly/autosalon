@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Добавить зарплату</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.salaries.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="id_сотрудника">Сотрудник</label>
                            <select name="id_сотрудника" id="id_сотрудника" class="form-control @error('id_сотрудника') is-invalid @enderror" required>
                                <option value="">Выберите сотрудника</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id_сотрудника }}" {{ old('id_сотрудника') == $employee->id_сотрудника ? 'selected' : '' }}>
                                        {{ $employee->first_name }} {{ $employee->last_name }} ({{ $employee->jobTitle->title }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_сотрудника')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="Сумма">Сумма</label>
                            <input type="number" step="0.01" name="Сумма" id="Сумма" class="form-control @error('Сумма') is-invalid @enderror" value="{{ old('Сумма') }}" required>
                            @error('Сумма')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="Тип_выплаты">Тип выплаты</label>
                            <select name="Тип_выплаты" id="Тип_выплаты" class="form-control @error('Тип_выплаты') is-invalid @enderror" required>
                                <option value="">Выберите тип выплаты</option>
                                <option value="Оклад" {{ old('Тип_выплаты') == 'Оклад' ? 'selected' : '' }}>Оклад</option>
                                <option value="Премия" {{ old('Тип_выплаты') == 'Премия' ? 'selected' : '' }}>Премия</option>
                                <option value="Штраф" {{ old('Тип_выплаты') == 'Штраф' ? 'selected' : '' }}>Штраф</option>
                            </select>
                            @error('Тип_выплаты')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="Дата_начисления">Дата начисления</label>
                            <input type="date" name="Дата_начисления" id="Дата_начисления" class="form-control @error('Дата_начисления') is-invalid @enderror" value="{{ old('Дата_начисления', date('Y-m-d')) }}" required>
                            @error('Дата_начисления')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="Комментарий">Комментарий</label>
                            <textarea name="Комментарий" id="Комментарий" class="form-control @error('Комментарий') is-invalid @enderror" rows="3">{{ old('Комментарий') }}</textarea>
                            @error('Комментарий')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                            <a href="{{ route('admin.salaries.index') }}" class="btn btn-secondary">Отмена</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 