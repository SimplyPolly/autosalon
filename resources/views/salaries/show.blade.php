@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Детали зарплаты</h2>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Основная информация</h5>
            <dl class="row">
                <dt class="col-sm-3">ID записи</dt>
                <dd class="col-sm-9">{{ $salary->id }}</dd>

                <dt class="col-sm-3">Период</dt>
                <dd class="col-sm-9">{{ \Carbon\Carbon::create()->month($salary->month)->format('F') }} {{ $salary->year }}</dd>

                <dt class="col-sm-3">Базовая ставка</dt>
                <dd class="col-sm-9">{{ number_format($salary->base_salary, 2) }} ₽</dd>

                <dt class="col-sm-3">Премия</dt>
                <dd class="col-sm-9">{{ number_format($salary->premium, 2) }} ₽</dd>

                <dt class="col-sm-3">Итого</dt>
                <dd class="col-sm-9">{{ number_format($salary->base_salary + $salary->premium, 2) }} ₽</dd>
            </dl>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Информация о сотруднике</h5>
            <dl class="row">
                <dt class="col-sm-3">Имя</dt>
                <dd class="col-sm-9">{{ $salary->employee->name }}</dd>

                <dt class="col-sm-3">Должность</dt>
                <dd class="col-sm-9">{{ $salary->employee->role->name }}</dd>
            </dl>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.salaries.index') }}" class="btn btn-secondary">К списку зарплат</a>
        <a href="{{ route('admin.salaries.edit', $salary) }}" class="btn btn-warning">Редактировать</a>
        <form action="{{ route('admin.salaries.destroy', $salary) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить эту запись?')">Удалить</button>
        </form>
    </div>
</div>
@endsection 