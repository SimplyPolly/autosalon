@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Статусы</h2>
    <a href="{{ route('admin.statuses.create') }}" class="btn btn-primary mb-3">Добавить статус</a>

    @if ($statuses->count())
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($statuses as $status)
            <tr>
                <td>{{ $status->id }}</td>
                <td>{{ $status->name }}</td>
                <td>{{ $status->description }}</td>
                <td>
                    <a href="{{ route('admin.statuses.show', $status) }}" class="btn btn-info btn-sm">Просмотр</a>
                    <a href="{{ route('admin.statuses.edit', $status) }}" class="btn btn-warning btn-sm">Редактировать</a>
                    <form action="{{ route('admin.statuses.destroy', $status) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены, что хотите удалить?')">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $statuses->links() }}
    @else
    <p>Нет данных.</p>
    @endif
</div>
@endsection 