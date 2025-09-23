@extends('layouts.catalog') {{-- Extend the catalog layout --}}

@section('title', 'Каталог товаров') {{-- Set the page title --}}

@section('table_headers') {{-- Define table headers --}}
    <th data-sort="name">Название <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="type_id">Тип <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="price">Цена <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="in_stock">Наличие <i class="fas fa-sort sort-icon"></i></th>
    <th>Действия</th>
@endsection

@section('table_content') {{-- Define table content --}}
    @include('car-products.table', ['carProducts' => $carProducts, 'employee' => $employee]) {{-- Include the table body partial and pass variables --}}
@endsection

@push('scripts')
<script>
    // JavaScript for car products specific actions, if any.
    // General search and sort are handled by layouts/catalog.blade.php

    // This part is for dynamic sorting icon updates on initial load/reload
    // It's still needed here to update the icons based on URL params.
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const sortField = urlParams.get('sort');
        const sortDirection = urlParams.get('direction');

        if (sortField) {
            const header = document.querySelector(`th[data-sort="${sortField}"]`);
            if (header) {
                const icon = header.querySelector('.sort-icon');
                if (icon) {
                    icon.className = `fas fa-sort-${sortDirection === 'asc' ? 'up' : 'down'} sort-icon`;
                }
            }
        }
    });
</script>
@endpush 