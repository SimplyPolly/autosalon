@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Добавить ремонтную работу</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('repair-works.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="car_id" class="form-label">Автомобиль</label>
                            <select class="form-select @error('car_id') is-invalid @enderror" id="car_id" name="car_id" required>
                                <option value="">Выберите автомобиль</option>
                                @foreach($cars as $car)
                                    <option value="{{ $car->id }}" {{ old('car_id') == $car->id ? 'selected' : '' }}>
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
                                    <option value="{{ $mechanic->id }}" {{ old('mechanic_id') == $mechanic->id ? 'selected' : '' }}>
                                        {{ $mechanic->first_name }} {{ $mechanic->last_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mechanic_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Описание</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="start_date" class="form-label">Дата начала</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="end_date" class="form-label">Дата завершения</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Статус</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Ожидает</option>
                                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>В процессе</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Завершено</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cost" class="form-label">Стоимость</label>
                            <input type="number" step="0.01" class="form-control @error('cost') is-invalid @enderror" id="cost" name="cost" value="{{ old('cost') }}" required>
                            @error('cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('repair-works.index') }}" class="btn btn-secondary">Назад</a>
                            <button type="submit" class="btn btn-primary">Создать</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 