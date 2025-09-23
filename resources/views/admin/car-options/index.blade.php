@extends('layouts.catalog')

@section('title', 'Опции автомобилей')

@section('create_button')
    @auth('employee')
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="fas fa-plus"></i> Добавить опцию
        </button>
    @endauth
@endsection

@section('table_headers')
    <th data-sort="ID_опции">ID <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="Название_опции">Название опции <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="Описание_опции">Описание опции <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="Стоимость_опции">Стоимость опции <i class="fas fa-sort sort-icon"></i></th>
    <th>Действия</th>
@endsection

@section('table_content')
    @forelse($carOptions as $option)
    <tr class="@if($loop->odd) table-active @endif">
        <td>{{ $option->ID_опции }}</td>
        <td>{{ $option->name }}</td>
        <td>{{ $option->description ?? 'N/A' }}</td>
        <td>{{ $option->price ? number_format($option->price, 2) . ' ₽' : 'N/A' }}</td>
        <td>
            <div class="btn-group">
                <a href="{{ route('admin.car-options.show', $option->id) }}" class="btn btn-sm btn-info me-2">Подробнее</a>
                <a href="{{ route('admin.car-options.edit', $option->id) }}" class="btn btn-sm btn-warning me-2">Редактировать</a>
                <button type="button" class="btn btn-sm btn-danger" onclick="deleteCarOption({{ $option->id }})">Удалить</button>
            </div>
        </td>
    </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center">Опций пока нет.</td>
        </tr>
    @endforelse
@endsection

@section('pagination')
    {{-- Pagination removed as controller now uses ->get() instead of ->paginate() --}}
@endsection

@section('create_form')
    <form action="{{ route('admin.car-options.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="Название_опции" class="form-label">Название опции</label>
            <input type="text" class="form-control" id="Название_опции" name="Название_опции" required>
        </div>
        <div class="mb-3">
            <label for="Описание_опции" class="form-label">Описание опции</label>
            <textarea class="form-control" id="Описание_опции" name="Описание_опции" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="Стоимость_опции" class="form-label">Стоимость опции</label>
            <input type="number" class="form-control" id="Стоимость_опции" name="Стоимость_опции" step="0.01">
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
@endsection

@push('scripts')
<script>
    // JavaScript for car options specific actions
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