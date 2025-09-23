@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Детали заявки на консультацию') }}</div>

                <div class="card-body">
                    <div class="mb-3">
                        <strong>{{ __('ID заявки:') }}</strong> {{ $consultationRequest->id }}
                    </div>
                    {{-- <div class="mb-3">
                        <strong>{{ __('Клиент:') }}</strong> {{ $consultationRequest->user->name ?? 'N/A' }}
                    </div> --}}
                    <div class="mb-3">
                        <strong>{{ __('Email клиента:') }}</strong> {{ $consultationRequest->user->email ?? 'N/A' }}
                    </div>
                    <div class="mb-3">
                        <strong>{{ __('Сотрудник:') }}</strong> 
                        @if($consultationRequest->employee)
                            {{ $consultationRequest->employee->first_name }} {{ $consultationRequest->employee->last_name }}
                        @else
                            {{ __('Не назначен') }}
                        @endif
                        @if (Auth::guard('employee')->check() && Auth::guard('employee')->user()->jobTitle && Auth::guard('employee')->user()->jobTitle->title === 'Администратор')
                            <form id="employee-assignment-form" class="employee-form" action="{{ route('employee.consultation-requests.update', $consultationRequest->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="{{ $consultationRequest->status }}">
                                <select name="employee_id" class="form-select form-select-sm d-inline-block w-auto">
                                    <option value="">{{ __('Не назначен') }}</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ $consultationRequest->employee_id == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->first_name }} {{ $employee->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary ms-2">{{ __('Сохранить') }}</button>
                            </form>
                        @endif
                    </div>
                    <div class="mb-3">
                        <strong>{{ __('Статус:') }}</strong>
                        @php
                            $statusTranslations = [
                                'pending' => 'В ожидании',
                                'in progress' => 'В работе',
                                'completed' => 'Завершена',
                                'cancelled' => 'Отменена',
                            ];
                        @endphp
                        @if (Auth::guard('employee')->check() && Auth::guard('employee')->user()->jobTitle && Auth::guard('employee')->user()->jobTitle->title === 'Администратор')
                            <form id="status-update-form" class="status-form" action="{{ route('employee.consultation-requests.update', $consultationRequest->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="employee_id" value="{{ $consultationRequest->employee_id }}">
                                <select name="status" class="form-select form-select-sm d-inline-block w-auto">
                                    @foreach ($statusTranslations as $key => $value)
                                        <option value="{{ $key }}" {{ $consultationRequest->status == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary ms-2">{{ __('Сохранить') }}</button>
                            </form>
                        @else
                            {{ $statusTranslations[$consultationRequest->status] ?? $consultationRequest->status }}
                        @endif
                    </div>
                    <div class="mb-3">
                        <strong>{{ __('Заметки:') }}</strong> {{ $consultationRequest->notes ?? __('Нет заметок') }}
                    </div>
                    <div class="mb-3">
                        <strong>{{ __('Предпочитаемая дата/время:') }}</strong> 
                        {{ $consultationRequest->scheduled_at ? \Carbon\Carbon::parse($consultationRequest->scheduled_at)->format('d.m.Y H:i') : __('Не указано') }}
                    </div>
                    <div class="mb-3">
                        <strong>{{ __('Создана:') }}</strong> {{ \Carbon\Carbon::parse($consultationRequest->created_at)->format('d.m.Y H:i') }}
                    </div>
                    <div class="mb-3">
                        <strong>{{ __('Последнее обновление:') }}</strong> {{ \Carbon\Carbon::parse($consultationRequest->updated_at)->format('d.m.Y H:i') }}
                    </div>

                    <a href="{{ route('employee.consultation-requests.index') }}" class="btn btn-secondary">{{ __('Вернуться к списку заявок') }}</a>

                    @if (Auth::guard('employee')->check() && $consultationRequest->status === 'pending' && is_null($consultationRequest->employee_id))
                        <form action="{{ route('employee.consultation-requests.take-in-work', $consultationRequest->id) }}" method="POST" class="d-inline ms-2">
                            @csrf
                            <button type="submit" class="btn btn-primary">{{ __('Взять в работу') }}</button>
                        </form>
                    @endif

                    @if (Auth::guard('employee')->check() && Auth::guard('employee')->user()->jobTitle && Auth::guard('employee')->user()->jobTitle->title === 'Администратор')
                        {{-- <div class="mb-3">
                            <strong>{{ __('Назначить сотрудника:') }}</strong>
                            <form action="{{ route('employee.consultation-requests.update', $consultationRequest->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <select name="employee_id" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                                    <option value="">{{ __('Не назначен') }}</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id_сотрудника }}" {{ $consultationRequest->employee_id == $employee->id_сотрудника ? 'selected' : '' }}>
                                            {{ $employee->Имя }} {{ $employee->Фамилия }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div> --}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    console.log('Inline script in show.blade.php loaded!');

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOMContentLoaded fired!');
        
        // Находим все формы на странице
        const allForms = document.querySelectorAll('form');
        console.log('All forms found:', allForms.length);
        
        // Находим форму назначения сотрудника
        const employeeForm = document.getElementById('employee-assignment-form');
        console.log('Employee assignment form found:', employeeForm ? 'Yes' : 'No');
        
        if (employeeForm) {
            console.log('Form action:', employeeForm.action);
            console.log('Form method:', employeeForm.method);
            
            employeeForm.addEventListener('submit', function(event) {
                console.log('Employee form submitted!');
                const formData = new FormData(employeeForm);
                console.log('Form data:');
                for (let [key, value] of formData.entries()) {
                    console.log(key + ':', value);
                }
            });
        }

        // Находим форму изменения статуса
        const statusForm = document.getElementById('status-update-form');
        console.log('Status update form found:', statusForm ? 'Yes' : 'No');
        
        if (statusForm) {
            console.log('Form action:', statusForm.action);
            console.log('Form method:', statusForm.method);
            
            statusForm.addEventListener('submit', function(event) {
                console.log('Status form submitted!');
                const formData = new FormData(statusForm);
                console.log('Form data:');
                for (let [key, value] of formData.entries()) {
                    console.log(key + ':', value);
                }
            });
        }

        // Добавляем обработчики для всех форм
        allForms.forEach((form, index) => {
            console.log(`Form ${index + 1}:`, {
                id: form.id,
                action: form.action,
                method: form.method,
                elements: form.elements.length
            });
            
            form.addEventListener('submit', function(event) {
                console.log(`Form ${index + 1} submitted!`);
                const formData = new FormData(form);
                console.log('Form data:');
                for (let [key, value] of formData.entries()) {
                    console.log(key + ':', value);
                }
            });
        });
    });
</script>

@endsection 