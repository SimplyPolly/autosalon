@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Статусы автомобилей</h2>
    <a href="{{ route('admin.car-statuses.create') }}" class="btn btn-primary mb-3">Добавить статус</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Статус автомобиля</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($carStatuses as $status)
            <tr>
                <td>{{ $status->ID_статуса_автомобиля }}</td>
                <td>{{ $status->Статус_автомобиля }}</td>
                <td>
                    <a href="{{ route('admin.car-statuses.show', $status->ID_статуса_автомобиля) }}" class="btn btn-info btn-sm">Просмотр</a>
                    <a href="{{ route('admin.car-statuses.edit', $status->ID_статуса_автомобиля) }}" class="btn btn-warning btn-sm">Редактировать</a>
                    <form action="{{ route('admin.car-statuses.destroy', $status->ID_статуса_автомобиля) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Удалить статус?')">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $carStatuses->links() }}
</div>
@endsection 