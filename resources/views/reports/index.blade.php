@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Отчеты</h2>
    
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Отчет по продажам</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.reports.sales') }}" method="GET">
                        <div class="form-group mb-3">
                            <label for="start_date">Начальная дата</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="end_date">Конечная дата</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Сформировать</button>
                        <a href="{{ route('admin.reports.sales.export') }}" class="btn btn-success">Экспорт в Excel</a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Отчет по ремонтам</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.reports.repairs') }}" method="GET">
                        <div class="form-group mb-3">
                            <label for="start_date">Начальная дата</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="end_date">Конечная дата</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Сформировать</button>
                        <a href="{{ route('admin.reports.repairs.export') }}" class="btn btn-success">Экспорт в Excel</a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Отчет по зарплатам</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.reports.salaries') }}" method="GET">
                        <div class="form-group mb-3">
                            <label for="month">Месяц</label>
                            <select class="form-control" id="month" name="month" required>
                                <option value="1">Январь</option>
                                <option value="2">Февраль</option>
                                <option value="3">Март</option>
                                <option value="4">Апрель</option>
                                <option value="5">Май</option>
                                <option value="6">Июнь</option>
                                <option value="7">Июль</option>
                                <option value="8">Август</option>
                                <option value="9">Сентябрь</option>
                                <option value="10">Октябрь</option>
                                <option value="11">Ноябрь</option>
                                <option value="12">Декабрь</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="year">Год</label>
                            <select class="form-control" id="year" name="year" required>
                                @for($i = date('Y'); $i >= date('Y')-5; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Сформировать</button>
                        <a href="{{ route('admin.reports.salaries.export') }}" class="btn btn-success">Экспорт в Excel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(isset($reportData))
    <div class="card">
        <div class="card-header">
            <h4>Результаты отчета</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            @foreach($reportData['headers'] as $header)
                                <th>{{ $header }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reportData['rows'] as $row)
                            <tr>
                                @foreach($row as $cell)
                                    <td>{{ $cell }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection 