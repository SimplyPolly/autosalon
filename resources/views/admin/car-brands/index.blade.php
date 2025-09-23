@extends('layouts.catalog')

@section('title', 'Бренды автомобилей')

@section('create_button')
    @auth('employee')
        @if($employee && $employee->jobTitle && $employee->jobTitle->title === 'Администратор')
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus"></i> Добавить бренд
            </button>
        @endif
    @endauth
@endsection

@section('table_headers')
    <th data-sort="id">ID <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="name">Название бренда <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="country_of_origin">Страна производитель <i class="fas fa-sort sort-icon"></i></th>
    <th>Действия</th>
@endsection

@section('table_content')
    @foreach($brands as $brand)
    <tr class="@if($loop->odd) table-active @endif">
        <td>{{ $brand->id }}</td>
        <td>{{ $brand->name }}</td>
        <td>{{ $brand->country_of_origin }}</td>
        <td>
            <div class="btn-group">
                <a href="{{ route('admin.car-brands.show', $brand) }}" class="btn btn-sm btn-info me-2">Подробнее</a>
                <a href="{{ route('admin.car-brands.edit', $brand) }}" class="btn btn-sm btn-warning me-2">Редактировать</a>
                <button type="button" class="btn btn-sm btn-danger" onclick="deleteCarBrand({{ $brand->id }})">Удалить</button>
            </div>
        </td>
    </tr>
    @endforeach
@endsection

@section('pagination')
    {{-- Pagination removed as controller now uses ->get() instead of ->paginate() --}}
@endsection

@section('create_form')
    <form action="{{ route('admin.car-brands.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Название бренда</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="country_of_origin" class="form-label">Страна производитель</label>
            <input type="text" class="form-control" id="country_of_origin" name="country_of_origin" required>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
@endsection

@push('scripts')
<script>
    // JavaScript for car brands specific actions
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