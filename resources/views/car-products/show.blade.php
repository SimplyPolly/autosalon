@extends('layouts.app') {{-- Возможно, вам потребуется изменить layout --}}

@section('content')
<div class="container">
    <h1>Детали автотовара</h1>

    @if($product)
        <h2>{{ $product->name ?? 'N/A' }}</h2>
        <p><strong>Цена:</strong> {{ number_format($product->price ?? 0, 2) }} ₽</p>
        <p><strong>Описание:</strong> {{ $product->description ?? 'Нет описания' }}</p>
        <p><strong>Тип товара:</strong> {{ $product->type->name ?? 'N/A' }}</p>
        <p><strong>Количество на складе:</strong> {{ $product->stock ?? 0 }}</p>
        {{-- Добавьте другие поля, которые хотите отобразить --}}

        <div class="mt-3">
            <a href="{{ route('car-products.index') }}" class="btn btn-primary">К списку автотоваров</a>
            @auth('employee')
                @if(Auth::guard('employee')->user()->role && Auth::guard('employee')->user()->role->name === 'Администратор')
                    <a href="{{ route('admin.car-products.edit', $product->id) }}" class="btn btn-warning">Изменить</a>
                    <form action="{{ route('admin.car-products.destroy', $product->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить этот товар?')">Удалить</button>
                    </form>
                @endif
            @endauth
        </div>
    @else
        <p>Автотовар не найден.</p>
    @endif
</div>
@endsection 