@extends('layouts.catalog')

@section('title', 'Каталог автомобилей')

@section('table_headers')
    <th data-sort="brand_id">Бренд <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="model_id">Модель <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="year">Год <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="color">Цвет <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="price">Цена <i class="fas fa-sort sort-icon"></i></th>
    <th data-sort="options">Опции <i class="fas fa-sort sort-icon"></i></th>
    @auth('employee')
        <th>Статус <i class="fas fa-sort sort-icon"></i></th>
    @endauth
    <th data-sort="salon_id">Салон <i class="fas fa-sort sort-icon"></i></th>
    <th>Действия</th>
@endsection

@section('table_content')
    @foreach($cars as $car)
        <tr class="@if($loop->odd) table-active @endif">
            {{-- Бренд --}}
            <td>{{ $car->brand->name ?? 'Н/Д' }}</td>
            {{-- Модель --}}
            <td>{{ $car->model->name ?? 'Н/Д' }}</td>
            {{-- Год --}}
            <td>{{ $car->year }}</td>
            {{-- Цвет --}}
            <td>{{ $car->color ?? 'Н/Д' }}</td>
            {{-- Цена --}}
            <td>{{ number_format($car->price, 2) }} ₽</td>
            {{-- Опции --}}
            <td>
                <div class="d-flex flex-wrap">
                    @php
                        $optionsArray = $car->options ? explode(', ', $car->options) : [];
                    @endphp
                    @forelse($optionsArray as $option)
                        <span class="badge bg-secondary me-1 mb-1">{{ trim($option) }}</span>
                    @empty
                        Нет опций
                    @endforelse
                </div>
            </td>
            @auth('employee')
                {{-- Статус --}}
                <td class="text-center">
                    @php
                        $statusName = $car->status->name ?? '';
                        $statusClass = match ($statusName) {
                            'В наличии' => 'success',
                            'Зарезервирован' => 'primary',
                            'На ремонте' => 'warning',
                            default => 'danger',
                        };
                    @endphp
                    <span class="badge bg-{{ $statusClass }}">{{ $statusName }}</span>
                </td>
            @endauth
            {{-- Салон --}}
            <td>{{ $car->salon->name ?? 'Н/Д' }}</td>
            {{-- Действия --}}
            <td class="text-nowrap">
                <div class="d-flex align-items-center">
                    <a href="{{ route('cars.show', $car) }}" class="btn btn-sm btn-info me-2">Подробнее</a>
                    @auth('employee')
                        @if(Auth::guard('employee')->user()->jobTitle?->title === 'Администратор')
                            <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-sm btn-primary me-2">Редактировать</a>
                            <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Вы уверены, что хотите удалить этот автомобиль?')">Удалить</button>
                            </form>
                        @endif
                    @endauth
                </div>
            </td>
        </tr>
    @endforeach
@endsection

@push('scripts')
    <script>
        function showDetails(id) {
            window.location.href = `/cars/${id}`;
        }

        // Генерация JS-функций ТОЛЬКО если пользователь — администратор
        @auth('employee')
            @if(Auth::guard('employee')->user()->jobTitle?->title === 'Администратор')
                function editCar(id) {
                    fetch("{{ url('admin/cars') }}/" + id + "/edit")
                        .then(response => response.json())
                        .then(data => {
                            const form = document.getElementById('editCarForm');
                            form.action = "{{ url('admin/cars') }}/" + id;

                            // Заполнение формы
                            document.getElementById('edit_brand_id').value = data.brand_id;
                            document.getElementById('edit_model_id').value = data.model_id;
                            document.getElementById('edit_year').value = data.year;
                            document.getElementById('edit_vin').value = data.vin;
                            document.getElementById('edit_price').value = data.price;
                            document.getElementById('edit_salon_id').value = data.salon_id;

                            // Статус
                            const editStatusSelect = document.getElementById('edit_status_id');
                            if (editStatusSelect) {
                                editStatusSelect.value = data.status_id;
                            }

                            // Опции
                            const editOptionsSelect = document.getElementById('edit_options');
                            if (editOptionsSelect && data.options) {
                                Array.from(editOptionsSelect.options).forEach(option => {
                                    option.selected = data.options.includes(parseInt(option.value));
                                });
                            }

                            new bootstrap.Modal(document.getElementById('editModal')).show();
                        })
                        .catch(err => console.error('Ошибка загрузки данных для редактирования:', err));
                }

                function deleteCar(id) {
                    if (confirm('Вы уверены, что хотите удалить этот автомобиль?')) {
                        fetch("{{ url('admin/cars') }}/" + id, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    window.location.reload();
                                } else {
                                    alert('Ошибка при удалении автомобиля');
                                }
                            })
                            .catch(err => {
                                alert('Произошла ошибка при удалении');
                                console.error(err);
                            });
                    }
                }
            @endif
        @endauth
    </script>
@endpush

@push('styles')
    <style>
        .badge {
            display: inline-block;
        }
    </style>
@endpush