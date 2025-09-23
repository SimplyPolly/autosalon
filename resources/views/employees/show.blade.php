@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Детали сотрудника</h2>
    <div class="card mb-4">
        <div class="card-header">
            <h3>Основная информация</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>ID сотрудника:</strong> {{ $employee->id }}</p>
                    <p><strong>Имя:</strong> {{ $employee->name }}</p>
                    <p><strong>Email:</strong> {{ $employee->email }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Телефон:</strong> {{ $employee->phone }}</p>
                    <p><strong>Должность:</strong> {{ $employee->position->name }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>История сделок</h3>
        </div>
        <div class="card-body">
            @if ($employee->deals->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Дата</th>
                        <th>Клиент</th>
                        <th>Автомобиль</th>
                        <th>Сумма</th>
                        <th>Статус</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employee->deals as $deal)
                    <tr>
                        <td>{{ $deal->id }}</td>
                        <td>{{ $deal->date->format('d.m.Y') }}</td>
                        <td>{{ $deal->client->name }}</td>
                        <td>{{ $deal->car->brand->name }} {{ $deal->car->model->name }}</td>
                        <td>{{ number_format($deal->total_amount, 2) }} ₽</td>
                        <td>{{ $deal->status->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>У сотрудника нет сделок.</p>
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>История ремонтов</h3>
        </div>
        <div class="card-body">
            @if ($employee->repairWorks->count())
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
                    @foreach ($employee->repairWorks as $work)
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
            <p>У сотрудника нет ремонтных работ.</p>
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>История зарплат</h3>
        </div>
        <div class="card-body">
            @if ($employee->salaries->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Период</th>
                        <th>Базовая ставка</th>
                        <th>Премия</th>
                        <th>Итого</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employee->salaries as $salary)
                    <tr>
                        <td>{{ $salary->id }}</td>
                        <td>{{ $salary->month }}/{{ $salary->year }}</td>
                        <td>{{ number_format($salary->base_salary, 2) }} ₽</td>
                        <td>{{ number_format($salary->premium, 2) }} ₽</td>
                        <td>{{ number_format($salary->base_salary + $salary->premium, 2) }} ₽</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>У сотрудника нет записей о зарплате.</p>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">К списку сотрудников</a>
        <a href="{{ route('admin.employees.edit', $employee) }}" class="btn btn-warning">Редактировать</a>
        <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить?')">Удалить</button>
        </form>
    </div>
</div>
@endsection 