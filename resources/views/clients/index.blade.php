@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Клиенты</h2>
    <a href="{{ route('admin.clients.create') }}" class="btn btn-primary mb-3">Добавить клиента</a>

    @if ($clients->count())
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Телефон</th>
                <th>Адрес</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
            <tr>
                <td>{{ $client->id }}</td>
                <td>{{ $client->name }}</td>
                <td>{{ $client->email }}</td>
                <td>{{ $client->phone }}</td>
                <td>{{ $client->address }}</td>
                <td>
                    <a href="{{ route('admin.clients.show', $client) }}" class="btn btn-info btn-sm">Просмотр</a>
                    <a href="{{ route('admin.clients.edit', $client) }}" class="btn btn-warning btn-sm">Редактировать</a>
                    <form action="{{ route('admin.clients.destroy', $client) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены, что хотите удалить?')">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $clients->links() }}
    @else
    <p>Нет данных.</p>
    @endif
</div>
@endsection 