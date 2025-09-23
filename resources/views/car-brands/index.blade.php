@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Марки автомобилей</h2>
    <a href="{{ route('admin.car-brands.create') }}" class="btn btn-primary mb-3">Добавить марку</a>

    @if ($brands->count())
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($brands as $brand)
            <tr>
                <td>{{ $brand->id }}</td>
                <td>{{ $brand->name }}</td>
                <td>{{ $brand->description }}</td>
                <td>
                    <a href="{{ route('admin.car-brands.show', $brand) }}" class="btn btn-info btn-sm">Просмотр</a>
                    <a href="{{ route('admin.car-brands.edit', $brand) }}" class="btn btn-warning btn-sm">Редактировать</a>
                    <form action="{{ route('admin.car-brands.destroy', $brand) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены, что хотите удалить?')">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $brands->links() }}
    @else
    <p>Нет данных.</p>
    @endif
</div>
@endsection 