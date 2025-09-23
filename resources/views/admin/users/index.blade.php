@extends('layouts.app')

@section('title', 'Пользователи')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Пользователи</h3>
            @auth('employee')
                @if($employee && $employee->jobTitle && $employee->jobTitle->title === 'Администратор')
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Добавить пользователя
                    </a>
                @endif
            @endauth
        </div>
        <div class="card-body">
            @if($users->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Фамилия</th>
                            <th>Отчество</th>
                            <th>Email</th>
                            <th>Телефон</th>
                            <th>Дата регистрации</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->middle_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->created_at ? $user->created_at->format('d.m.Y H:i') : 'Н/Д' }}</td>
                                <td>
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info btn-sm">Подробнее</a>
                                    @auth('employee')
                                        @if($employee && $employee->jobTitle && $employee->jobTitle->title === 'Администратор')
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm">Изменить</a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
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
                <div class="alert alert-info">Пользователи не найдены.</div>
            @endif
        </div>
    </div>
</div>
@endsection 