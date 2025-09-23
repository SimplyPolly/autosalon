@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ремонтные работы</h2>
    <a href="{{ route('admin.repair-works.create') }}" class="btn btn-primary mb-3">Добавить новую работу</a>

    @if ($repairWorks->count())
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Автомобиль</th>
                <th>Сотрудник</th>
                <th>Дата начала</th>
                <th>Дата окончания</th>
                <th>Статус</th>
                <th>Стоимость</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($repairWorks as $work)
            <tr>
                <td>{{ $work->id }}</td>
                <td>{{ $work->car->brand->name }} {{ $work->car->model->name }}</td>
                <td>{{ $work->employee->name }}</td>
                <td>{{ $work->start_date->format('d.m.Y') }}</td>
                <td>{{ $work->end_date ? $work->end_date->format('d.m.Y') : 'В процессе' }}</td>
                <td>{{ $work->status->name }}</td>
                <td>{{ number_format($work->cost, 2) }} ₽</td>
                <td>
                    <a href="{{ route('admin.repair-works.show', $work) }}" class="btn btn-info btn-sm">Просмотр</a>
                    <a href="{{ route('admin.repair-works.edit', $work) }}" class="btn btn-warning btn-sm">Редактировать</a>
                    <form action="{{ route('admin.repair-works.destroy', $work) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены, что хотите удалить?')">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $repairWorks->links() }}
    @else
    <p>Нет данных.</p>
    @endif
</div>
@endsection 