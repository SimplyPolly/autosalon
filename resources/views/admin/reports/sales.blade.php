@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Отчет по продажам</h2>
        <a href="{{ route('admin.reports.sales.export') }}" class="btn btn-success">
            <i class="fas fa-file-excel"></i> Экспорт в Excel
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Статистика продаж по месяцам</h3>
        </div>
        <div class="card-body">
            @if($salesData->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Месяц</th>
                            <th>Количество сделок</th>
                            <th>Общая сумма</th>
                            <th>Средняя сумма сделки</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($salesData as $data)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($data->month)->format('F Y') }}</td>
                                <td>{{ $data->total_deals }}</td>
                                <td>{{ number_format($data->total_amount, 2) }} ₽</td>
                                <td>{{ number_format($data->total_amount / $data->total_deals, 2) }} ₽</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Нет данных о продажах.</p>
            @endif
        </div>
    </div>

    <!-- Самые продаваемые автомобили -->
    <div class="card mb-4">
        <div class="card-header">
            <h3>Самые продаваемые автомобили</h3>
        </div>
        <div class="card-body">
            @if($topCars->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Марка</th>
                            <th>Модель</th>
                            <th>Количество продаж</th>
                            <th>Общая выручка</th>
                            <th>Средняя цена</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topCars as $car)
                            <tr>
                                <td>{{ $car->brand }}</td>
                                <td>{{ $car->model }}</td>
                                <td>{{ $car->total_sales }}</td>
                                <td>{{ number_format($car->total_amount, 2) }} ₽</td>
                                <td>{{ number_format($car->total_amount / $car->total_sales, 2) }} ₽</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Нет данных о продажах автомобилей.</p>
            @endif
        </div>
    </div>

    <!-- График продаж -->
    <div class="card mb-4">
        <div class="card-header">
            <h3>График продаж</h3>
        </div>
        <div class="card-body">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Top Selling Cars -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="table-container">
                <h6 class="mb-3">Топ продаваемых автомобилей</h6>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Марка<a href="#"><span>&#9650;&#9660;</span></a></th>
                            <th>Модель<a href="#"><span>&#9650;&#9660;</span></a></th>
                            <th>Количество продаж<a href="#"><span>&#9650;&#9660;</span></a></th>
                            <th>Общая выручка<a href="#"><span>&#9650;&#9660;</span></a></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topCars as $car)
                            <tr>
                                <td>{{ $car->Марка }}</td>
                                <td>{{ $car->Модель }}</td>
                                <td>{{ $car->total_sales }}</td>
                                <td>{{ number_format($car->total_amount, 2) }} ₽</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Sales by Employee -->
    <div class="row">
        <div class="col-md-12">
            <div class="table-container">
                <h6 class="mb-3">Продажи по сотрудникам</h6>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Сотрудник<a href="#"><span>&#9650;&#9660;</span></a></th>
                            <th>Количество сделок<a href="#"><span>&#9650;&#9660;</span></a></th>
                            <th>Общая сумма<a href="#"><span>&#9650;&#9660;</span></a></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($salesByEmployee as $employee)
                            <tr>
                                <td>{{ $employee->ФИО }}</td>
                                <td>{{ $employee->total_deals }}</td>
                                <td>{{ number_format($employee->total_amount, 2) }} ₽</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesData = @json($salesData);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: salesData.map(item => moment(item.month).format('MMM YYYY')),
            datasets: [{
                label: 'Сумма продаж',
                data: salesData.map(item => item.total_amount),
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString() + ' ₽';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection 