@extends('layouts.catalog')

@section('title', 'Управление сотрудниками')

@section('create_button')
    @auth('employee')
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="fas fa-plus"></i> Добавить сотрудника
        </button>
    @endauth
@endsection

@section('table_headers')
    <th data-sort="id">ID <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="ФИО">ФИО <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="email">Email <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="phone">Телефон <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="jobTitle.title">Должность <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="salon.name">Салон <i class="fas fa-sort sort-icon"></i></th>
    <th>Действия</th>
@endsection

@section('table_content')
    @foreach($employees as $employee)
        <tr>
            <td>{{ $employee->id }}</td>
            <td>{{ $employee->last_name }} {{ $employee->first_name }} {{ $employee->middle_name }}</td>
            <td>{{ $employee->email }}</td>
            <td>{{ $employee->phone }}</td>
            <td>{{ $employee->jobTitle->title ?? '' }}</td>
            <td>{{ $employee->salon->name ?? '' }}</td>
            <td>
                <a href="{{ route('admin.employees.show', $employee) }}" class="btn btn-sm btn-info">Подробнее</a>
                <a href="{{ route('admin.employees.edit', $employee) }}" class="btn btn-sm btn-primary">Изменить</a>
                <button type="button" class="btn btn-sm btn-danger" onclick="deleteEmployee({{ $employee->id }})">Удалить</button>
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

    function deleteEmployee(id) {
        if (confirm('Вы уверены, что хотите удалить этого сотрудника?')) {
            fetch(`/admin/employees/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'X-HTTP-Method-Override': 'DELETE'
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    performSearch(document.getElementById('searchInput').value, {}, '/admin/employees');
                } else {
                    alert('Ошибка при удалении сотрудника.');
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                alert('Произошла ошибка при удалении сотрудника.');
            });
        }
    }
</script>
@endpush 