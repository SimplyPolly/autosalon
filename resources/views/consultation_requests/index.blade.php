@extends('layouts.catalog')

@section('title', 'Заявки на консультацию')

@section('table_headers')
    <th>ID</th>
    <th>Email клиента</th>
    <th>Сотрудник</th>
    <th>Статус</th>
    <th>Дата/Время</th>
    <th>Действия</th>
@endsection

@section('table_content')
    @forelse ($consultationRequests as $request)
        <tr>
            <td>{{ $request->id }}</td>
            <td>{{ $request->user->email ?? 'N/A' }}</td>
            <td>
                @if($request->employee)
                    {{ $request->employee->first_name }} {{ $request->employee->last_name }}
                @else
                    Не назначен
                @endif
            </td>
            <td>
                @php
                    $statusTranslations = [
                        'pending' => 'В ожидании',
                        'in progress' => 'В работе',
                        'completed' => 'Завершена',
                        'cancelled' => 'Отменена',
                    ];
                @endphp
                {{ $statusTranslations[$request->status] ?? $request->status }}
            </td>
            <td>{{ $request->scheduled_at ? \Carbon\Carbon::parse($request->scheduled_at)->format('d.m.Y H:i') : 'Не указано' }}</td>
            <td>
                <div class="btn-group">
                    <a href="{{ route('employee.consultation-requests.show', $request->id) }}" class="btn btn-info btn-sm">Подробнее</a>
                    @auth('employee')
                        @if(Auth::guard('employee')->user()->jobTitle && Auth::guard('employee')->user()->jobTitle->title === 'Администратор')
                            <form action="{{ route('admin.consultation-requests.destroy', $request->id) }}" method="POST" class="d-inline ms-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены, что хотите удалить эту заявку?')">Удалить</button>
                            </form>
                        @endif
                    @endauth
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6">Заявок на консультацию пока нет.</td>
        </tr>
    @endforelse
@endsection

@push('scripts')
<script>
    // This part is for dynamic sorting icon updates on initial load/reload
    // It's still needed here to update the icons based on URL params.
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
</script>
@endpush 