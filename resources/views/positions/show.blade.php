@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Детали должности</h2>
    <div class="card mb-4">
        <div class="card-header">
            <h3>Основная информация</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>ID должности:</strong> {{ $position->id }}</p>
                    <p><strong>Название:</strong> {{ $position->name }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Описание:</strong></p>
                    <p>{{ $position->description }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Сотрудники на этой должности</h3>
        </div>
        <div class="card-body">
            @if ($position->employees->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Телефон</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($position->employees as $employee)
                    <tr>
                        <td>{{ $employee->id }}</td>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->phone }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>Нет сотрудников на этой должности.</p>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.positions.index') }}" class="btn btn-secondary">К списку должностей</a>
        <a href="{{ route('admin.positions.edit', $position) }}" class="btn btn-warning">Редактировать</a>
        <form action="{{ route('admin.positions.destroy', $position) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить?')">Удалить</button>
        </form>
    </div>
</div>
@endsection 