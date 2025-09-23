@extends('layouts.catalog')

@section('title', 'Статусы автомобилей')

@section('table_headers')
    <th data-sort="id">ID <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="name">Название статуса <i class="fas fa-sort sort-icon"></i></th>
    <th>Действия</th>
@endsection

@section('table_content')
    @foreach($carStatuses as $status)
    <tr class="@if($loop->odd) table-active @endif">
        <td>{{ $status->id }}</td>
        <td>{{ $status->name }}</td>
        <td>
            <div class="btn-group">
                <a href="{{ route('admin.car-statuses.show', $status) }}" class="btn btn-sm btn-info me-2">Подробнее</a>
                <a href="{{ route('admin.car-statuses.edit', $status) }}" class="btn btn-sm btn-warning me-2">Редактировать</a>
                <button type="button" class="btn btn-sm btn-danger" onclick="deleteCarStatus({{ $status->id }})">Удалить</button>
            </div>
        </td>
    </tr>
    @endforeach
@endsection

@section('pagination')
    {{-- Pagination removed as controller now uses ->get() instead of ->paginate() --}}
@endsection

@section('create_form')
    <form action="{{ route('admin.car-statuses.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Название статуса</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
@endsection

@push('scripts')
<script>
    // JavaScript for car statuses specific actions
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