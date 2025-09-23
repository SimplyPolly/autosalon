@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Ремонтные работы</h2>
        <a href="{{ route('repair-works.create') }}" class="btn btn-primary">Добавить работу</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($repairWorks->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Автомобиль</th>
                                <th>Механик</th>
                                <th>Описание</th>
                                <th>Дата начала</th>
                                <th>Дата завершения</th>
                                <th>Статус</th>
                                <th>Стоимость</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($repairWorks as $work)
                                <tr>
                                    <td>{{ $work->id }}</td>
                                    <td>{{ $work->car->brand->name }} {{ $work->car->model->name }}</td>
                                    <td>{{ $work->employee->first_name }} {{ $work->employee->last_name }}</td>
                                    <td>{{ $work->description }}</td>
                                    <td>{{ $work->start_date }}</td>
                                    <td>{{ $work->end_date ?? 'Не завершено' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $work->status === 'completed' ? 'success' : ($work->status === 'in_progress' ? 'warning' : 'secondary') }}">
                                            {{ $work->status === 'completed' ? 'Завершено' : ($work->status === 'in_progress' ? 'В процессе' : 'Ожидает') }}
                                        </span>
                                    </td>
                                    <td>{{ number_format($work->cost, 2) }} ₽</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('repair-works.edit', $work) }}" class="btn btn-sm btn-primary">Редактировать</a>
                                            <form action="{{ route('repair-works.destroy', $work) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены, что хотите удалить эту работу?')">Удалить</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center">Ремонтные работы не найдены</p>
            @endif
        </div>
    </div>
</div>
@endsection 