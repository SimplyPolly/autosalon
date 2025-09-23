@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Детали сделки</h2>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Основная информация</h5>
            <dl class="row">
                <dt class="col-sm-3">ID сделки</dt>
                <dd class="col-sm-9">{{ $deal->id }}</dd>

                <dt class="col-sm-3">Дата сделки</dt>
                <dd class="col-sm-9">{{ $deal->deal_date->format('d.m.Y') }}</dd>

                <dt class="col-sm-3">Сумма сделки</dt>
                <dd class="col-sm-9">{{ number_format($deal->amount, 2) }} ₽</dd>
            </dl>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Информация об автомобиле</h5>
            <dl class="row">
                <dt class="col-sm-3">Марка</dt>
                <dd class="col-sm-9">{{ $deal->car->brand->name }}</dd>

                <dt class="col-sm-3">Модель</dt>
                <dd class="col-sm-9">{{ $deal->car->model->name }}</dd>

                <dt class="col-sm-3">Цена</dt>
                <dd class="col-sm-9">{{ number_format($deal->car->price, 2) }} ₽</dd>
            </dl>
        </div>
    </div>

    @if($deal->product)
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Информация о товаре</h5>
            <dl class="row">
                <dt class="col-sm-3">Название</dt>
                <dd class="col-sm-9">{{ $deal->product->name }}</dd>

                <dt class="col-sm-3">Цена</dt>
                <dd class="col-sm-9">{{ number_format($deal->product->price, 2) }} ₽</dd>
            </dl>
        </div>
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Информация о клиенте</h5>
            <dl class="row">
                <dt class="col-sm-3">Имя</dt>
                <dd class="col-sm-9">{{ $deal->client->name }}</dd>

                <dt class="col-sm-3">Телефон</dt>
                <dd class="col-sm-9">{{ $deal->client->phone }}</dd>

                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{ $deal->client->email }}</dd>
            </dl>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Информация о сотруднике</h5>
            <dl class="row">
                <dt class="col-sm-3">Имя</dt>
                <dd class="col-sm-9">{{ $deal->employee->name }}</dd>

                <dt class="col-sm-3">Должность</dt>
                <dd class="col-sm-9">{{ $deal->employee->role->name }}</dd>
            </dl>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.deals.index') }}" class="btn btn-secondary">К списку сделок</a>
        <a href="{{ route('admin.deals.edit', $deal) }}" class="btn btn-warning">Редактировать</a>
        <form action="{{ route('admin.deals.destroy', $deal) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить эту сделку?')">Удалить</button>
        </form>
    </div>
</div>
@endsection 