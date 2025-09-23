@extends('layouts.app')

@section('title', 'Каталог автотоваров')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Каталог автотоваров</h2>
        @auth('employee')
            @if($employee && $employee->jobTitle && $employee->jobTitle->title === 'Администратор')
                <a href="{{ route('admin.car-products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Добавить товар
                </a>
            @endif
        @endauth
    </div>
    @if($carProducts->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Тип</th>
                    <th>Описание</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carProducts as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->type->name ?? '' }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ number_format($product->price, 2) }} ₽</td>
                        <td>{{ $product->quantity }}</td>
                        <td>
                            <a href="{{ route('admin.car-products.show', $product->id) }}" class="btn btn-info btn-sm">Подробнее</a>
                            @auth('employee')
                                @if($employee && $employee->jobTitle && $employee->jobTitle->title === 'Администратор')
                                    <a href="{{ route('admin.car-products.edit', $product->id) }}" class="btn btn-primary btn-sm">Изменить</a>
                                    <form action="{{ route('admin.car-products.destroy', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены?')">Удалить</button>
                                    </form>
                                @endif
                            @endauth
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $carProducts->links() }}
    @else
        <div class="alert alert-info">Автотовары не найдены.</div>
    @endif
</div>
@endsection 