@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Премии сотрудников</h2>
    <a href="{{ route('admin.premiums.create') }}" class="btn btn-primary mb-3">Добавить премию</a>

    @if ($premiums->count())
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Сотрудник</th>
                <th>Дата</th>
                <th>Сумма</th>
                <th>Причина</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($premiums as $premium)
            <tr>
                <td>{{ $premium->id }}</td>
                <td>{{ $premium->employee->name }}</td>
                <td>{{ $premium->date->format('d.m.Y') }}</td>
                <td>{{ number_format($premium->amount, 2) }} ₽</td>
                <td>{{ $premium->reason }}</td>
                <td>
                    <a href="{{ route('admin.premiums.show', $premium) }}" class="btn btn-info btn-sm">Просмотр</a>
                    <a href="{{ route('admin.premiums.edit', $premium) }}" class="btn btn-warning btn-sm">Редактировать</a>
                    <form action="{{ route('admin.premiums.destroy', $premium) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены, что хотите удалить?')">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $premiums->links() }}
    @else
    <p>Нет данных.</p>
    @endif
</div>
@endsection 