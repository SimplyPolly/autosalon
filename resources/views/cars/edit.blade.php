@extends('layouts.app')

@section('title', 'Редактировать автомобиль')

@section('content')
<div class="container">
    <h2>Редактировать автомобиль</h2>
    <form method="POST" action="{{ route('admin.cars.update', $car->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="brand_id" class="form-label">Марка</label>
            <div class="input-group">
                <select class="form-select" id="brand_id" name="brand_id" required>
                    @foreach($carBrands as $brand)
                        <option value="{{ $brand->id }}" {{ $car->brand_id == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
                @auth('employee')
                    @if(Auth::guard('employee')->user()->hasRole('Administrator'))
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#createRelatedModal" data-modal-title="Создать марку" data-form-url="{{ route('admin.car-brands.create_modal') }}">Создать</button>
                    @endif
                @endauth
            </div>
        </div>

        <div class="mb-3">
            <label for="model_id" class="form-label">Модель</label>
            <div class="input-group">
                <select class="form-select" id="model_id" name="model_id" required>
                    @foreach($carModels as $model)
                        <option value="{{ $model->id }}" {{ $car->model_id == $model->id ? 'selected' : '' }}>
                            {{ $model->name }}
                        </option>
                    @endforeach
                </select>
                @auth('employee')
                    @if(Auth::guard('employee')->user()->hasRole('Administrator'))
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#createRelatedModal" data-modal-title="Создать модель" data-form-url="{{ route('admin.car-models.create_modal') }}">Создать</button>
                    @endif
                @endauth
            </div>
        </div>

        <div class="mb-3">
            <label for="year" class="form-label">Год</label>
            <input type="number" class="form-control" id="year" name="year" value="{{ old('year', $car->year) }}" min="1900" max="{{ date('Y') }}" required>
        </div>

        <div class="mb-3">
            <label for="vin" class="form-label">VIN</label>
            <input type="text" class="form-control" id="vin" name="vin" value="{{ old('vin', $car->vin) }}" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Цена</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ old('price', $car->price) }}" required>
        </div>

        @auth('employee')
            <div class="mb-3">
                <label for="status_id" class="form-label">Статус</label>
                <select class="form-select" id="status_id" name="status_id" required>
                    @foreach($carStatuses as $status)
                        <option value="{{ $status->id }}" {{ $car->status_id == $status->id ? 'selected' : '' }}>
                            {{ $status->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endauth

        <div class="mb-3">
            <label for="salon_id" class="form-label">Салон</label>
            <div class="input-group">
                <select class="form-select" id="salon_id" name="salon_id" required>
                    @foreach($salons as $salon)
                        <option value="{{ $salon->id }}" {{ $car->salon_id == $salon->id ? 'selected' : '' }}>
                            {{ $salon->name }}
                        </option>
                    @endforeach
                </select>
                @auth('employee')
                    @if(Auth::guard('employee')->user()->hasRole('Administrator'))
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#createRelatedModal" data-modal-title="Создать салон" data-form-url="{{ route('admin.salons.create_modal') }}">Создать</button>
                    @endif
                @endauth
            </div>
        </div>
        
        <div class="mb-3">
            <label for="price" class="form-label">Цена</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ old('price', $car->price) }}" required>
        </div>

        <div class="mb-3">
            <label for="options" class="form-label">Опции</label>
            <input type="text" class="form-control" id="options" name="option" value="{{ old('car_option', $car->options) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Обновить</button>
        <a href="{{ route('cars.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>
@endsection

@push('scripts')
<div class="modal fade" id="createRelatedModal" tabindex="-1" aria-labelledby="createRelatedModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRelatedModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const createRelatedModal = document.getElementById('createRelatedModal');
        createRelatedModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const modalTitle = button.getAttribute('data-modal-title');
            const formUrl = button.getAttribute('data-form-url');

            const modalBody = createRelatedModal.querySelector('.modal-body');
            const modalHeaderTitle = createRelatedModal.querySelector('.modal-title');

            modalHeaderTitle.textContent = modalTitle;
            modalBody.innerHTML = '<p>Загрузка...</p>'; 

            fetch(formUrl)
                .then(response => response.text())
                .then(html => {
                    modalBody.innerHTML = html;
                    const form = modalBody.querySelector('form');
                    if (form) {
                        form.addEventListener('submit', function (e) {
                            e.preventDefault();
                            const formData = new FormData(form);
                            const actionUrl = form.action;

                            fetch(actionUrl, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                },
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    const selectId = data.select_id; // e.g., 'brand_id'
                                    const newOptionId = data.new_id;
                                    const newOptionText = data.new_text;

                                    const selectElement = document.getElementById(selectId);
                                    if (selectElement) {
                                        const newOption = new Option(newOptionText, newOptionId, true, true);
                                        selectElement.add(newOption);
                                    }
                                    bootstrap.Modal.getInstance(createRelatedModal).hide();
                                } else {
                                    alert('Ошибка: ' + (data.message || 'Не удалось создать запись.'));
                                    if (data.errors) {
                                        let errorMessages = '';
                                        for (const field in data.errors) {
                                            errorMessages += field + ': ' + data.errors[field].join(', ') + '\n';
                                        }
                                        alert('Ошибки валидации:\n' + errorMessages);
                                    }
                                }
                            })
                            .catch(error => {
                                console.error('Ошибка:', error);
                                alert('Произошла ошибка при отправке данных.');
                            });
                        });
                    }
                })
                .catch(error => {
                    modalBody.innerHTML = '<p class="text-danger">Ошибка загрузки формы.</p>';
                    console.error('Ошибка загрузки формы:', error);
                });
        });

        createRelatedModal.addEventListener('hidden.bs.modal', function () {
            createRelatedModal.querySelector('.modal-body').innerHTML = '';
            createRelatedModal.querySelector('.modal-title').textContent = '';
        });
    });
</script>
@endpush