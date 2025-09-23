@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Должности</h2>
    <a href="{{ route('admin.positions.create') }}" class="btn btn-primary mb-3">Добавить должность</a>

    @if ($positions->count())
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
            @foreach ($positions as $position)
            <tr>
                <td>{{ $position->id }}</td>
                <td>{{ $position->name }}</td>
                <td>{{ $position->description }}</td>
                <td>
                    <a href="{{ route('admin.positions.show', $position) }}" class="btn btn-info btn-sm">Просмотр</a>
                    <a href="{{ route('admin.positions.edit', $position) }}" class="btn btn-warning btn-sm">Редактировать</a>
                    <form action="{{ route('admin.positions.destroy', $position) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены, что хотите удалить?')">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $positions->links() }}
    @else
    <p>Нет данных.</p>
    @endif
</div>
@endsection 