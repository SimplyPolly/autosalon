@extends('layouts.app')

@section('title', 'Премии сотрудников')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Премии сотрудников</h2>
        @auth('employee')
            @if($employee && $employee->jobTitle && $employee->jobTitle->title === 'Администратор')
                <a href="{{ route('admin.premiums.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Добавить премию
                </a>
            @endif
        @endauth
    </div>
    @if($premiums->count())
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
                @foreach($premiums as $premium)
                    <tr>
                        <td>{{ $premium->id }}</td>
                        <td>{{ $premium->employee->last_name ?? '' }} {{ $premium->employee->first_name ?? '' }}</td>
                        <td>{{ $premium->description }}</td>
                        <td>{{ number_format($premium->amount, 2) }} ₽</td>
                        <td>{{ \Carbon\Carbon::parse($premium->payment_date)->format('d.m.Y') }}</td>
                        <td>
                            <a href="{{ route('admin.premiums.show', $premium->id) }}" class="btn btn-info btn-sm">Подробнее</a>
                            @auth('employee')
                                @if($employee && $employee->jobTitle && $employee->jobTitle->title === 'Администратор')
                                    <a href="{{ route('admin.premiums.edit', $premium->id) }}" class="btn btn-primary btn-sm">Изменить</a>
                                    <form action="{{ route('admin.premiums.destroy', $premium->id) }}" method="POST" class="d-inline">
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
        <div class="alert alert-info">Премии пока нет.</div>
    @endif
</div>
@endsection 