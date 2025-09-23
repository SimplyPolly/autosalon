@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Детали клиента</h2>
    <div class="card mb-4">
        <div class="card-header">
            <h3>Основная информация</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>ID клиента:</strong> {{ $client->id }}</p>
                    <p><strong>Имя:</strong> {{ $client->name }}</p>
                    <p><strong>Email:</strong> {{ $client->email }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Телефон:</strong> {{ $client->phone }}</p>
                    <p><strong>Адрес:</strong></p>
                    <p>{{ $client->address }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>История сделок</h3>
        </div>
        <div class="card-body">
            @if ($client->deals->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Дата</th>
                        <th>Автомобиль</th>
                        <th>Сотрудник</th>
                        <th>Сумма</th>
                        <th>Статус</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($client->deals as $deal)
                    <tr>
                        <td>{{ $deal->id }}</td>
                        <td>{{ $deal->date->format('d.m.Y') }}</td>
                        <td>{{ $deal->car->brand->name }} {{ $deal->car->model->name }}</td>
                        <td>{{ $deal->employee->name }}</td>
                        <td>{{ number_format($deal->total_amount, 2) }} ₽</td>
                        <td>{{ $deal->status->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>У клиента нет сделок.</p>
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>История ремонтов</h3>
        </div>
        <div class="card-body">
            @if ($client->repairWorks->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Автомобиль</th>
                        <th>Дата начала</th>
                        <th>Дата окончания</th>
                        <th>Стоимость</th>
                        <th>Статус</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($client->repairWorks as $work)
                    <tr>
                        <td>{{ $work->id }}</td>
                        <td>{{ $work->car->brand->name }} {{ $work->car->model->name }}</td>
                        <td>{{ $work->start_date->format('d.m.Y') }}</td>
                        <td>{{ $work->end_date ? $work->end_date->format('d.m.Y') : 'В процессе' }}</td>
                        <td>{{ number_format($work->cost, 2) }} ₽</td>
                        <td>{{ $work->status->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>У клиента нет ремонтных работ.</p>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">К списку клиентов</a>
        <a href="{{ route('admin.clients.edit', $client) }}" class="btn btn-warning">Редактировать</a>
        <form action="{{ route('admin.clients.destroy', $client) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить?')">Удалить</button>
        </form>
    </div>
</div>
@endsection 