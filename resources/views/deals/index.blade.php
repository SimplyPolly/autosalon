@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Сделки</h2>
    <a href="{{ route('admin.deals.create') }}" class="btn btn-primary mb-3">Создать новую сделку</a>

    @if ($deals->count())
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Автомобиль</th>
                <th>Товар</th>
                <th>Клиент</th>
                <th>Сотрудник</th>
                <th>Дата сделки</th>
                <th>Сумма</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($deals as $deal)
            <tr>
                <td>{{ $deal->id }}</td>
                <td>{{ $deal->car->brand->name }} {{ $deal->car->model->name }}</td>
                <td>{{ $deal->product->name ?? 'N/A' }}</td>
                <td>{{ $deal->client->name }}</td>
                <td>{{ $deal->employee->name }}</td>
                <td>{{ $deal->deal_date->format('d.m.Y') }}</td>
                <td>{{ number_format($deal->amount, 2) }} ₽</td>
                <td>
                    <a href="{{ route('admin.deals.show', $deal) }}" class="btn btn-info btn-sm">Просмотр</a>
                    <a href="{{ route('admin.deals.edit', $deal) }}" class="btn btn-warning btn-sm">Редактировать</a>
                    <form action="{{ route('admin.deals.destroy', $deal) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены, что хотите удалить?')">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $deals->links() }}
    @else
    <p>Нет данных.</p>
    @endif
</div>
@endsection 