@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>@yield('title')</h2>
        </div>
        <div class="col-md-4 text-end">
            @auth('employee')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="fas fa-plus"></i> Добавить
                </button>
            @endauth
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchInput" placeholder="Поиск...">
                        <button class="btn btn-primary" type="button" id="searchButton">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            @yield('table_headers')
                        </tr>
                    </thead>
                    <tbody>
                        @yield('table_content')
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно создания -->
@auth('employee')
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Добавить запись</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if(Auth::guard('employee')->check() && Auth::guard('employee')->user()->hasRole('Administrator'))
                    @if(request()->routeIs('cars*'))
                        @include('admin.cars._create_form')
                    @elseif(request()->routeIs('car-products*'))
                        @include('admin.car-products._create_form')
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно редактирования -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Редактировать запись</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if(Auth::guard('employee')->check() && Auth::guard('employee')->user()->hasRole('Administrator'))
                    @if(request()->routeIs('cars*'))
                        {{-- @include('admin.cars._edit_form') --}}
                    @elseif(request()->routeIs('car-products*'))
                        @include('admin.car-products._edit_form')
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endauth

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<style>
    .table th {
        cursor: pointer;
    }
    .table th:hover {
        background-color: #f8f9fa;
    }
    .sort-icon {
        margin-left: 5px;
    }
    .btn-group {
        gap: 5px;
    }
    .modal-dialog {
        max-width: 600px;
    }

    .salaries-table-container table {
        width: 100%;
        table-layout: fixed;
    }

    .salaries-table-container th,
    .salaries-table-container td {
        padding: 8px 12px; /* Add some padding */
    }

    .salaries-table-container th:nth-child(1),
    .salaries-table-container td:nth-child(1) {
        width: 8% !important; /* ID */
        text-align: center;
    }

    .salaries-table-container th:nth-child(2),
    .salaries-table-container td:nth-child(2) { /* Сотрудник */
        width: 13% !important;
        text-align: left;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    .salaries-table-container th:nth-child(3),
    .salaries-table-container td:nth-child(3) { /* Должность */
        width: 8% !important;
        text-align: left;
    }

    .salaries-table-container th:nth-child(4),
    .salaries-table-container td:nth-child(4) { /* Сумма */
        width: 10% !important;
        text-align: left;
    }

    .salaries-table-container th:nth-child(5),
    .salaries-table-container td:nth-child(5) { /* Тип выплаты */
        width: 10% !important;
        text-align: left;
    }

    .salaries-table-container th:nth-child(6),
    .salaries-table-container td:nth-child(6) { /* Дата начисления */
        width: 15% !important;
        text-align: center;
    }

    .salaries-table-container th:nth-child(7),
    .salaries-table-container td:nth-child(7) { /* Действия */
        width: 36% !important;
        text-align: center;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Функционал сортировки
    const tableHeaders = document.querySelectorAll('th[data-sort]');
    tableHeaders.forEach(header => {
        header.addEventListener('click', () => {
            const sortField = header.dataset.sort;
            const currentDirection = header.dataset.direction || 'asc';
            const newDirection = currentDirection === 'asc' ? 'desc' : 'asc';
            
            // Обновляем иконки сортировки
            tableHeaders.forEach(h => h.dataset.direction = '');
            header.dataset.direction = newDirection;
            
            // Вызываем функцию сортировки с текущим ресурсным путем
            let resourcePath;
            if (window.location.pathname.startsWith('/cars')) {
                resourcePath = '/cars';
            } else if (window.location.pathname.startsWith('/car-products')) {
                resourcePath = '/car-products';
            } else if (window.location.pathname.startsWith('/employee/consultation-requests')) {
                resourcePath = '/employee/consultation-requests';
            } else if (window.location.pathname.startsWith('/admin/employees')) {
                resourcePath = '/admin/employees';
            } else if (window.location.pathname.startsWith('/admin/users')) {
                resourcePath = '/admin/users';
            } else if (window.location.pathname.startsWith('/admin/car-product-types')) {
                resourcePath = '/admin/car-product-types';
            } else if (window.location.pathname.startsWith('/admin/car-statuses')) {
                resourcePath = '/admin/car-statuses';
            } else if (window.location.pathname.startsWith('/admin/car-options')) {
                resourcePath = '/admin/car-options';
            } else if (window.location.pathname.startsWith('/admin/car-models')) {
                resourcePath = '/admin/car-models';
            } else if (window.location.pathname.startsWith('/admin/deals')) {
                resourcePath = '/admin/deals';
            } else if (window.location.pathname.startsWith('/admin/premiums')) {
                resourcePath = '/admin/premiums';
            } else if (window.location.pathname.startsWith('/admin/salaries')) {
                resourcePath = '/admin/salaries';
            } else if (window.location.pathname.startsWith('/admin/salons')) {
                resourcePath = '/admin/salons';
            } else if (window.location.pathname.startsWith('/admin/job-titles')) {
                resourcePath = '/admin/job-titles';
            }
            
            if (resourcePath) {
                fetch(`${resourcePath}/sort?field=${sortField}&direction=${newDirection}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const tbody = document.querySelector('tbody');
                            tbody.innerHTML = data.html;
                        }
                    });
            }
        });
    });

    // Функционал поиска
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');

    function performSearch() {
        const searchTerm = searchInput.value.trim();
        if (searchTerm) {
            const currentPath = window.location.pathname;
            fetch(`${currentPath}?search=${encodeURIComponent(searchTerm)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const tbody = document.querySelector('tbody');
                        tbody.innerHTML = data.html;
                    }
                });
        }
    }

    searchButton.addEventListener('click', performSearch);
    searchInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            performSearch();
        }
    });
});

function deleteCar(id) {
    if (confirm('Вы уверены, что хотите удалить этот автомобиль?')) {
        fetch(`/employee/cars/${id}`, {
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
                const resourcePath = window.location.pathname.startsWith('/cars') ? '/cars' : '/car-products';
                performSearch(document.getElementById('searchInput').value, {}, resourcePath);
            } else {
                alert('Ошибка при удалении автомобиля.');
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            alert('Произошла ошибка при удалении автомобиля.');
        });
    }
}

function deleteCarProduct(id) {
    if (confirm('Вы уверены, что хотите удалить этот товар?')) {
        fetch(`/employee/car-products/${id}`, {
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
                performSearch(document.getElementById('searchInput').value, {}, '/car-products');
            } else {
                alert('Ошибка при удалении товара.');
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            alert('Произошла ошибка при удалении товара.');
        });
    }
}

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

function deleteUser(id) {
    if (confirm('Вы уверены, что хотите удалить этого пользователя?')) {
        fetch(`/admin/users/${id}`, {
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
                performSearch(document.getElementById('searchInput').value, {}, '/admin/users');
            } else {
                alert('Ошибка при удалении пользователя.');
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            alert('Произошла ошибка при удалении пользователя.');
        });
    }
}

function deleteCarProductType(id) {
    if (confirm('Вы уверены, что хотите удалить этот тип автотовара?')) {
        fetch(`/admin/car-product-types/${id}`, {
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
                performSearch(document.getElementById('searchInput').value, {}, '/admin/car-product-types');
            } else {
                alert('Ошибка при удалении типа автотовара.');
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            alert('Произошла ошибка при удалении типа автотовара.');
        });
    }
}

function deleteCarStatus(id) {
    if (confirm('Вы уверены, что хотите удалить этот статус?')) {
        fetch(`/admin/car-statuses/${id}`, {
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
                performSearch(document.getElementById('searchInput').value, {}, '/admin/car-statuses');
            } else {
                alert('Ошибка при удалении статуса.');
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            alert('Произошла ошибка при удалении статуса.');
        });
    }
}

function deleteCarOption(id) {
    if (confirm('Вы уверены, что хотите удалить эту опцию?')) {
        fetch(`/admin/car-options/${id}`, {
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
                performSearch(document.getElementById('searchInput').value, {}, '/admin/car-options');
            } else {
                alert('Ошибка при удалении опции.');
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            alert('Произошла ошибка при удалении опции.');
        });
    }
}

function deleteCarModel(id) {
    if (confirm('Вы уверены, что хотите удалить эту модель?')) {
        fetch(`/admin/car-models/${id}`, {
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
                performSearch(document.getElementById('searchInput').value, {}, '/admin/car-models');
            } else {
                alert('Ошибка при удалении модели.');
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            alert('Произошла ошибка при удалении модели.');
        });
    }
}

function deleteDeal(id) {
    if (confirm('Вы уверены, что хотите удалить эту сделку?')) {
        fetch(`/admin/deals/${id}`, {
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
                performSearch(document.getElementById('searchInput').value, {}, '/admin/deals');
            } else {
                alert('Ошибка при удалении сделки.');
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            alert('Произошла ошибка при удалении сделки.');
        });
    }
}

function deletePremium(id) {
    if (confirm('Вы уверены, что хотите удалить эту премию?')) {
        fetch(`/admin/premiums/${id}`, {
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
                performSearch(document.getElementById('searchInput').value, {}, '/admin/premiums');
            } else {
                alert('Ошибка при удалении премии.');
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            alert('Произошла ошибка при удалении премии.');
        });
    }
}

function deleteSalary(id) {
    if (confirm('Вы уверены, что хотите удалить эту зарплату?')) {
        fetch(`/admin/salaries/${id}`, {
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
                performSearch(document.getElementById('searchInput').value, {}, '/admin/salaries');
            } else {
                alert('Ошибка при удалении зарплаты.');
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            alert('Произошла ошибка при удалении зарплаты.');
        });
    }
}

function deleteSalon(id) {
    if (confirm('Вы уверены, что хотите удалить этот салон?')) {
        fetch(`/admin/salons/${id}`, {
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
                performSearch(document.getElementById('searchInput').value, {}, '/admin/salons');
            } else {
                alert('Ошибка при удалении салона.');
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            alert('Произошла ошибка при удалении салона.');
        });
    }
}

function deleteJobTitle(id) {
    if (confirm('Вы уверены, что хотите удалить эту должность?')) {
        fetch(`/admin/job-titles/${id}`, {
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
                performSearch(document.getElementById('searchInput').value, {}, '/admin/job-titles');
            } else {
                alert('Ошибка при удалении должности.');
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            alert('Произошла ошибка при удалении должности.');
        });
    }
}

function exportToExcel() {
    window.location.href = '/api/export/excel';
}

function exportToPDF() {
    window.location.href = '/api/export/pdf';
}
</script>
@endpush
@endsection 