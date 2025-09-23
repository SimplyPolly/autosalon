@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Отчет по зарплатам</h2>
        <a href="{{ route('admin.reports.salary.export') }}" class="btn btn-success">
            <i class="fas fa-file-excel"></i> Экспорт в Excel
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Статистика зарплат по месяцам</h3>
        </div>
        <div class="card-body">
            @if($salaryData->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Месяц</th>
                            <th>Количество выплат</th>
                            <th>Общая сумма</th>
                            <th>Средняя зарплата</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($salaryData as $data)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($data->month)->format('F Y') }}</td>
                                <td>{{ $data->total_payments }}</td>
                                <td>{{ number_format($data->total_amount, 2) }} ₽</td>
                                <td>{{ number_format($data->total_amount / $data->total_payments, 2) }} ₽</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Нет данных о зарплатах.</p>
            @endif
        </div>
    </div>

    <!-- Статистика по должностям -->
    <div class="card mb-4">
        <div class="card-header">
            <h3>Статистика по должностям</h3>
        </div>
        <div class="card-body">
            @if($salaryByPosition->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Должность</th>
                            <th>Количество сотрудников</th>
                            <th>Общая сумма</th>
                            <th>Средняя зарплата</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($salaryByPosition as $position)
                            <tr>
                                <td>{{ $position->title }}</td>
                                <td>{{ $position->total_employees }}</td>
                                <td>{{ number_format($position->total_amount, 2) }} ₽</td>
                                <td>{{ number_format($position->avg_salary, 2) }} ₽</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Нет данных по должностям.</p>
            @endif
        </div>
    </div>
</div>
@endsection 