@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Детали ремонтной работы</h2>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Основная информация</h5>
            <dl class="row">
                <dt class="col-sm-3">ID работы</dt>
                <dd class="col-sm-9">{{ $work->id }}</dd>

                <dt class="col-sm-3">Дата начала</dt>
                <dd class="col-sm-9">{{ $work->start_date->format('d.m.Y') }}</dd>

                <dt class="col-sm-3">Дата окончания</dt>
                <dd class="col-sm-9">{{ $work->end_date ? $work->end_date->format('d.m.Y') : 'В процессе' }}</dd>

                <dt class="col-sm-3">Статус</dt>
                <dd class="col-sm-9">{{ $work->status->name }}</dd>

                <dt class="col-sm-3">Стоимость</dt>
                <dd class="col-sm-9">{{ number_format($work->cost, 2) }} ₽</dd>

                <dt class="col-sm-3">Описание работ</dt>
                <dd class="col-sm-9">{{ $work->description }}</dd>
            </dl>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Информация об автомобиле</h5>
            <dl class="row">
                <dt class="col-sm-3">Марка</dt>
                <dd class="col-sm-9">{{ $work->car->brand->name }}</dd>

                <dt class="col-sm-3">Модель</dt>
                <dd class="col-sm-9">{{ $work->car->model->name }}</dd>

                <dt class="col-sm-3">Год выпуска</dt>
                <dd class="col-sm-9">{{ $work->car->year }}</dd>
            </dl>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Информация о сотруднике</h5>
            <dl class="row">
                <dt class="col-sm-3">Имя</dt>
                <dd class="col-sm-9">{{ $work->employee->name }}</dd>

                <dt class="col-sm-3">Должность</dt>
                <dd class="col-sm-9">{{ $work->employee->role->name }}</dd>
            </dl>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.repair-works.index') }}" class="btn btn-secondary">К списку работ</a>
        <a href="{{ route('admin.repair-works.edit', $work) }}" class="btn btn-warning">Редактировать</a>
        <form action="{{ route('admin.repair-works.destroy', $work) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить эту работу?')">Удалить</button>
        </form>
    </div>
</div>
@endsection 