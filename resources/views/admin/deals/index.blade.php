@extends('layouts.catalog')

@section('title', 'Управление сделками')

@section('create_button')
    @auth('employee')
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="fas fa-plus"></i> Добавить сделку
        </button>
    @endauth
@endsection

@section('table_headers')
    <th data-sort="id_сделки">ID <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="client.Фамилия">Клиент <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="employee.Фамилия">Сотрудник <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="car.Название_модели">Автомобиль <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="Дата_сделки">Дата сделки <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="Общая_сумма">Общая сумма <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="Статус_сделки">Статус <i class="fas fa-sort sort-icon"></i></th>
    <th>Действия</th>
@endsection

@section('table_content')
    @forelse($deals as $deal)
        <tr>
            <td>{{ $deal->id_сделки }}</td>
            <td>{{ $deal->client->Фамилия }} {{ $deal->client->Имя }}</td>
            <td>{{ $deal->employee->Фамилия }} {{ $deal->employee->Имя }}</td>
            <td>{{ $deal->car->brand->Название_марки }} {{ $deal->car->model->Название_модели }}</td>
            <td>{{ \Carbon\Carbon::parse($deal->Дата_сделки)->format('d.m.Y') }}</td>
            <td>{{ number_format($deal->Общая_сумма, 2) }} ₽</td>
            <td>{{ $deal->Статус_сделки }}</td>
            <td>
                <a href="{{ route('admin.deals.show', $deal->id_сделки) }}" class="btn btn-sm btn-info">Подробнее</a>
                <a href="{{ route('admin.deals.edit', $deal->id_сделки) }}" class="btn btn-sm btn-primary">Изменить</a>
                <button type="button" class="btn btn-sm btn-danger" onclick="deleteDeal({{ $deal->id_сделки }})">Удалить</button>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="text-center">Сделок пока нет.</td>
        </tr>
    @endforelse
@endsection

@section('pagination')
    {{ $deals->links() }}
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const initialSortField = urlParams.get('field');
        const initialSortDirection = urlParams.get('direction');

        if (initialSortField) {
            const header = document.querySelector(`th[data-sort='${initialSortField}']`);
            if (header) {
                header.dataset.direction = initialSortDirection || 'asc';
            }
        }
    });
</script>
@endpush 