@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Редактировать сотрудника</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.employees.update', $employee) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="Фамилия" class="form-label">Фамилия</label>
                            <input type="text" class="form-control @error('Фамилия') is-invalid @enderror" id="Фамилия" name="Фамилия" value="{{ old('Фамилия', $employee->Фамилия) }}" required>
                            @error('Фамилия')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Имя" class="form-label">Имя</label>
                            <input type="text" class="form-control @error('Имя') is-invalid @enderror" id="Имя" name="Имя" value="{{ old('Имя', $employee->Имя) }}" required>
                            @error('Имя')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Отчество" class="form-label">Отчество</label>
                            <input type="text" class="form-control @error('Отчество') is-invalid @enderror" id="Отчество" name="Отчество" value="{{ old('Отчество', $employee->Отчество) }}">
                            @error('Отчество')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Телефон" class="form-label">Телефон</label>
                            <input type="text" class="form-control @error('Телефон') is-invalid @enderror" id="Телефон" name="Телефон" value="{{ old('Телефон', $employee->Телефон) }}">
                            @error('Телефон')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $employee->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Пароль" class="form-label">Новый пароль (оставьте пустым, чтобы не менять)</label>
                            <input type="password" class="form-control @error('Пароль') is-invalid @enderror" id="Пароль" name="Пароль">
                            @error('Пароль')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="job_title_id" class="form-label">Должность</label>
                            <select class="form-select @error('job_title_id') is-invalid @enderror" id="job_title_id" name="job_title_id" required>
                                <option value="">Выберите должность</option>
                                @foreach($jobTitles as $jobTitle)
                                    <option value="{{ $jobTitle->id }}" {{ old('job_title_id', $employee->job_title_id) == $jobTitle->id ? 'selected' : '' }}>
                                        {{ $jobTitle->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('job_title_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="id_салона" class="form-label">Салон</label>
                            <select class="form-select @error('id_салона') is-invalid @enderror" id="id_салона" name="id_салона" required>
                                <option value="">Выберите салон</option>
                                @foreach($salons as $salon)
                                    <option value="{{ $salon->id_салона }}" {{ old('id_салона', $employee->id_салона) == $salon->id_салона ? 'selected' : '' }}>
                                        {{ $salon->Название }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_салона')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">Назад</a>
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 