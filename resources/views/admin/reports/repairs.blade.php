@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Отчёт по ремонтным работам</h1>

        <!-- Статистика по месяцам -->
        <div class="card mb-4">
            <div class="card-header">
                <h2>Статистика по месяцам</h2>
            </div>
            @if($repairData->isNotEmpty())
                <table class="table">
                    <thead>
                        <tr>
                            <th>Месяц</th>
                            <th>Всего работ</th>
                            <th>Общая стоимость</th>
                            <th>Средняя стоимость</th>
                            <th>Завершено работ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($repairData as $data)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($data->month)->format('F Y') }}</td>
                                <td>{{ $data->total_repairs }}</td>
                                <td>{{ number_format($data->total_cost, 2) }} ₽</td>
                                <td>{{ number_format($data->total_cost / $data->total_repairs, 2) }} ₽</td>
                                <td>{{ $data->completed_repairs }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Нет данных о ремонтных работах.</p>
            @endif
        </div>

        <!-- Статистика по механикам -->
        <div class="card">
            <div class="card-header">
                <h2>Статистика по механикам</h2>
            </div>
            @if($mechanicStats->isNotEmpty())
                <table class="table">
                    <thead>
                        <tr>
                            <th>Механик</th>
                            <th>Всего работ</th>
                            <th>Общая стоимость</th>
                            <th>Средняя стоимость</th>
                            <th>Завершено работ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mechanicStats as $stat)
                            <tr>
                                <td>{{ $stat->first_name }} {{ $stat->last_name }}</td>
                                <td>{{ $stat->total_repairs }}</td>
                                <td>{{ number_format($stat->total_cost, 2) }} ₽</td>
                                <td>{{ number_format($stat->total_cost / $stat->total_repairs, 2) }} ₽</td>
                                <td>{{ $stat->completed_repairs }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Нет данных о работах механиков.</p>
            @endif
        </div>
    </div>
@endsection 