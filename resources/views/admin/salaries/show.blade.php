@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Детали зарплаты</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">ID</th>
                                    <td>{{ $salary->id_зарплаты }}</td>
                                </tr>
                                <tr>
                                    <th>Сотрудник</th>
                                    <td>{{ $salary->employee->Фамилия }} {{ $salary->employee->Имя }} {{ $salary->employee->Отчество }}</td>
                                </tr>
                                <tr>
                                    <th>Должность</th>
                                    <td>{{ $salary->employee->jobTitle->title }}</td>
                                </tr>
                                <tr>
                                    <th>Сумма</th>
                                    <td>{{ number_format($salary->Сумма, 2) }} ₽</td>
                                </tr>
                                <tr>
                                    <th>Тип выплаты</th>
                                    <td>{{ $salary->Тип_выплаты }}</td>
                                </tr>
                                <tr>
                                    <th>Дата выплаты</th>
                                    <td>{{ $salary->Дата_выплаты->format('d.m.Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Комментарий</th>
                                    <td>{{ $salary->Комментарий }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.salaries.edit', $salary->id_зарплаты) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Редактировать
                        </a>
                        <form action="{{ route('admin.salaries.destroy', $salary->id_зарплаты) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены?')">
                                <i class="fas fa-trash"></i> Удалить
                            </button>
                        </form>
                        <a href="{{ route('admin.salaries.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Назад к списку
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 