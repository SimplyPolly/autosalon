@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Сотрудники</h2>
    <a href="{{ route('admin.employees.create') }}" class="btn btn-primary mb-3">Добавить сотрудника</a>

    @if ($employees->count())
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Телефон</th>
                <th>Должность</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
            <tr>
                <td>{{ $employee->id }}</td>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->phone }}</td>
                <td>{{ $employee->position->name }}</td>
                <td>
                    <a href="{{ route('admin.employees.show', $employee) }}" class="btn btn-info btn-sm">Просмотр</a>
                    <a href="{{ route('admin.employees.edit', $employee) }}" class="btn btn-warning btn-sm">Редактировать</a>
                    <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены, что хотите удалить?')">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $employees->links() }}
    @else
    <p>Нет данных.</p>
    @endif
</div>
@endsection 