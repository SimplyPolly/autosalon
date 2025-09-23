@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Редактировать ремонтную работу</h2>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('repair-works.update', $repairWork) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="car_id" class="form-label">Автомобиль</label>
                            <select class="form-select @error('car_id') is-invalid @enderror" id="car_id" name="car_id" required>
                                <option value="">Выберите автомобиль</option>
                                @foreach($cars as $car)
                                    <option value="{{ $car->id }}" {{ (old('car_id', $repairWork->car_id) == $car->id) ? 'selected' : '' }}>
                                        {{ $car->brand->name }} {{ $car->model->name }} ({{ $car->vin }})
                                    </option>
                                @endforeach
                            </select>
                            @error('car_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="mechanic_id" class="form-label">Механик</label>
                            <select class="form-select @error('mechanic_id') is-invalid @enderror" id="mechanic_id" name="mechanic_id" required>
                                <option value="">Выберите механика</option>
                                @foreach($mechanics as $mechanic)
                                    <option value="{{ $mechanic->id }}" {{ (old('mechanic_id', $repairWork->mechanic_id) == $mechanic->id) ? 'selected' : '' }}>
                                        {{ $mechanic->first_name }} {{ $mechanic->last_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mechanic_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Описание работ</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description', $repairWork->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="repair_date" class="form-label">Дата начала работ</label>
                            <input type="date" class="form-control @error('repair_date') is-invalid @enderror" id="repair_date" name="repair_date" value="{{ old('repair_date', $repairWork->repair_date) }}" required>
                            @error('repair_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="completion_date" class="form-label">Дата завершения работ</label>
                            <input type="date" class="form-control @error('completion_date') is-invalid @enderror" id="completion_date" name="completion_date" value="{{ old('completion_date', $repairWork->completion_date) }}">
                            @error('completion_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status_id" class="form-label">Статус</label>
                            <select class="form-select @error('status_id') is-invalid @enderror" id="status_id" name="status_id" required>
                                <option value="">Выберите статус</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ (old('status_id', $repairWork->status_id) == $status->id) ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cost" class="form-label">Стоимость</label>
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control @error('cost') is-invalid @enderror" id="cost" name="cost" value="{{ old('cost', $repairWork->cost) }}" required>
                                <span class="input-group-text">₽</span>
                                @error('cost')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('repair-works.index') }}" class="btn btn-secondary">Отмена</a>
                            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 