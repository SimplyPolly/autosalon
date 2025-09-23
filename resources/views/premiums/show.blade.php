@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Детали премии</h2>
    <div class="card mb-4">
        <div class="card-header">
            <h3>Основная информация</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>ID записи:</strong> {{ $premium->id }}</p>
                    <p><strong>Дата:</strong> {{ $premium->date->format('d.m.Y') }}</p>
                    <p><strong>Сумма:</strong> {{ number_format($premium->amount, 2) }} ₽</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Причина:</strong></p>
                    <p>{{ $premium->reason }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Информация о сотруднике</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Имя:</strong> {{ $premium->employee->name }}</p>
                    <p><strong>Должность:</strong> {{ $premium->employee->position->name }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.premiums.index') }}" class="btn btn-secondary">К списку премий</a>
        <a href="{{ route('admin.premiums.edit', $premium) }}" class="btn btn-warning">Редактировать</a>
        <form action="{{ route('admin.premiums.destroy', $premium) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить?')">Удалить</button>
        </form>
    </div>
</div>
@endsection 