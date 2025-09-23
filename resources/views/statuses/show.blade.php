@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Детали статуса</h2>
    <div class="card mb-4">
        <div class="card-header">
            <h3>Основная информация</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>ID статуса:</strong> {{ $status->id }}</p>
                    <p><strong>Название:</strong> {{ $status->name }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Описание:</strong></p>
                    <p>{{ $status->description }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Объекты с этим статусом</h3>
        </div>
        <div class="card-body">
            @if ($status->cars->count() > 0)
            <h4>Автомобили</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Марка</th>
                        <th>Модель</th>
                        <th>Год выпуска</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($status->cars as $car)
                    <tr>
                        <td>{{ $car->id }}</td>
                        <td>{{ $car->brand->name }}</td>
                        <td>{{ $car->model->name }}</td>
                        <td>{{ $car->year }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

            @if ($status->repairWorks->count() > 0)
            <h4>Ремонтные работы</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Автомобиль</th>
                        <th>Сотрудник</th>
                        <th>Дата начала</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($status->repairWorks as $work)
                    <tr>
                        <td>{{ $work->id }}</td>
                        <td>{{ $work->car->brand->name }} {{ $work->car->model->name }}</td>
                        <td>{{ $work->employee->name }}</td>
                        <td>{{ $work->start_date->format('d.m.Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

            @if ($status->cars->count() == 0 && $status->repairWorks->count() == 0)
            <p>Нет объектов с этим статусом.</p>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.statuses.index') }}" class="btn btn-secondary">К списку статусов</a>
        <a href="{{ route('admin.statuses.edit', $status) }}" class="btn btn-warning">Редактировать</a>
        <form action="{{ route('admin.statuses.destroy', $status) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить?')">Удалить</button>
        </form>
    </div>
</div>
@endsection 