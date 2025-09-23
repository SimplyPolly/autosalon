@extends('layouts.catalog')

@section('title', 'Управление должностями')

@section('create_button')
    @auth('employee')
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="fas fa-plus"></i> Добавить должность
        </button>
    @endauth
@endsection

@section('table_headers')
    <th data-sort="id">ID <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="title">Название должности <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="description">Описание <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="daily_salary">Оклад <i class="fas fa-sort sort-icon"></i></th>
    <th>Действия</th>
@endsection

@section('table_content')
    @foreach($jobTitles as $jobTitle)
        <tr>
            <td>{{ $jobTitle->id }}</td>
            <td>{{ $jobTitle->title }}</td>
            <td>{{ $jobTitle->description }}</td>
            <td>{{ number_format($jobTitle->daily_salary, 2) }} ₽</td>
            <td>
                <a href="{{ route('admin.job-titles.show', $jobTitle->id) }}" class="btn btn-sm btn-info">Подробнее</a>
                <a href="{{ route('admin.job-titles.edit', $jobTitle->id) }}" class="btn btn-sm btn-primary">Изменить</a>
                <button type="button" class="btn btn-sm btn-danger" onclick="deleteJobTitle({{ $jobTitle->id }})">Удалить</button>
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