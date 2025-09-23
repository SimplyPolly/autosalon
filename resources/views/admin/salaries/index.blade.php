@extends('layouts.app')

@section('title', 'Зарплаты сотрудников')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Зарплаты сотрудников</h2>
        @auth('employee')
            @if($employee && $employee->jobTitle && $employee->jobTitle->title === 'Администратор')
                <a href="{{ route('admin.salaries.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Добавить зарплату
                </a>
            @endif
        @endauth
    </div>
    @if($salaries->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Сотрудник</th>
                    <th>Описание</th>
                    <th>Сумма</th>
                    <th>Дата выплаты</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salaries as $salary)
                    <tr>
                        <td>{{ $salary->id }}</td>
                        <td>{{ $salary->employee->last_name ?? '' }} {{ $salary->employee->first_name ?? '' }}</td>
                        <td>{{ $salary->description }}</td>
                        <td>{{ number_format($salary->amount, 2) }} ₽</td>
                        <td>{{ \Carbon\Carbon::parse($salary->payment_date)->format('d.m.Y') }}</td>
                        <td>
                            <a href="{{ route('admin.salaries.show', $salary->id) }}" class="btn btn-info btn-sm">Подробнее</a>
                            @auth('employee')
                                @if($employee && $employee->jobTitle && $employee->jobTitle->title === 'Администратор')
                                    <a href="{{ route('admin.salaries.edit', $salary->id) }}" class="btn btn-primary btn-sm">Изменить</a>
                                    <form action="{{ route('admin.salaries.destroy', $salary->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены?')">Удалить</button>
                                    </form>
                                @endif
                            @endauth
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">Зарплаты пока не начислялись.</div>
    @endif
</div>
@endsection 