@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Редактировать должность</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.job-titles.update', $jobTitle) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="Название_должности" class="form-label">Название должности</label>
                            <input type="text" class="form-control @error('Название_должности') is-invalid @enderror" 
                                id="Название_должности" name="Название_должности" 
                                value="{{ old('Название_должности', $jobTitle->Название_должности) }}" required>
                            @error('Название_должности')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Описание" class="form-label">Описание</label>
                            <textarea class="form-control @error('Описание') is-invalid @enderror" 
                                id="Описание" name="Описание" rows="3">{{ old('Описание', $jobTitle->Описание) }}</textarea>
                            @error('Описание')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Оклад" class="form-label">Оклад</label>
                            <input type="number" step="0.01" class="form-control @error('Оклад') is-invalid @enderror" 
                                id="Оклад" name="Оклад" 
                                value="{{ old('Оклад', $jobTitle->Оклад) }}" required>
                            @error('Оклад')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.job-titles.index') }}" class="btn btn-secondary">Назад</a>
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 