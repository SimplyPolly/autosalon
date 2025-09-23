@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Зарплаты сотрудников</h2>
    <a href="{{ route('admin.salaries.create') }}" class="btn btn-primary mb-3">Добавить запись о зарплате</a>

    @if ($salaries->count())
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Сотрудник</th>
                <th>Месяц</th>
                <th>Год</th>
                <th>Базовая ставка</th>
                <th>Премия</th>
                <th>Итого</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($salaries as $salary)
            <tr>
                <td>{{ $salary->id }}</td>
                <td>{{ $salary->employee->name }}</td>
                <td>{{ $salary->month }}</td>
                <td>{{ $salary->year }}</td>
                <td>{{ number_format($salary->base_salary, 2) }} ₽</td>
                <td>{{ number_format($salary->premium, 2) }} ₽</td>
                <td>{{ number_format($salary->base_salary + $salary->premium, 2) }} ₽</td>
                <td>
                    <a href="{{ route('admin.salaries.show', $salary) }}" class="btn btn-info btn-sm">Просмотр</a>
                    <a href="{{ route('admin.salaries.edit', $salary) }}" class="btn btn-warning btn-sm">Редактировать</a>
                    <form action="{{ route('admin.salaries.destroy', $salary) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены, что хотите удалить?')">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $salaries->links() }}
    @else
    <p>Нет данных.</p>
    @endif
</div>
@endsection 