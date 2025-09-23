@extends('layouts.catalog')

@section('title', 'Управление салонами')

@section('create_button')
    @auth('employee')
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="fas fa-plus"></i> Добавить салон
        </button>
    @endauth
@endsection

@section('table_headers')
    <th data-sort="id">ID <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="name">Название салона <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="address">Адрес <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="phone">Телефон <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="email">Email <i class="fas fa-sort sort-icon"></i></th>
    <th>Действия</th>
@endsection

@section('table_content')
    @foreach($salons as $salon)
        <tr>
            <td>{{ $salon->id }}</td>
            <td>{{ $salon->name }}</td>
            <td>{{ $salon->address }}</td>
            <td>{{ $salon->phone }}</td>
            <td>{{ $salon->email }}</td>
            <td>
                <a href="{{ route('admin.salons.show', $salon) }}" class="btn btn-sm btn-info">Подробнее</a>
                <a href="{{ route('admin.salons.edit', $salon) }}" class="btn btn-sm btn-primary">Изменить</a>
                <button type="button" class="btn btn-sm btn-danger" onclick="deleteSalon({{ $salon->id }})">Удалить</button>
            </td>
        </tr>
    @endforeach
@endsection

@section('pagination')
    {{-- Pagination removed as controller now uses ->get() instead of ->paginate() --}}
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