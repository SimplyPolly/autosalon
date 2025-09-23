@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Опции автомобилей</h2>
    <a href="{{ route('admin.car-options.create') }}" class="btn btn-primary mb-3">Добавить опцию</a>

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
                <th>Название опции</th>
                <th>Описание опции</th>
                <th>Стоимость опции</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($carOptions as $option)
            <tr>
                <td>{{ $option->ID_опции }}</td>
                <td>{{ $option->Название_опции }}</td>
                <td>{{ $option->Описание_опции ?? 'N/A' }}</td>
                <td>{{ $option->Стоимость_опции ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('admin.car-options.show', $option->ID_опции) }}" class="btn btn-info btn-sm">Просмотр</a>
                    <a href="{{ route('admin.car-options.edit', $option->ID_опции) }}" class="btn btn-warning btn-sm">Редактировать</a>
                    <form action="{{ route('admin.car-options.destroy', $option->ID_опции) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Удалить опцию?')">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $carOptions->links() }}
</div>
@endsection 