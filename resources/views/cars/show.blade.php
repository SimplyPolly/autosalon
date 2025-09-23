@extends('layouts.app') {{-- Adjust layout as needed --}}

@section('content')
    <div class="container">
        <h1>Детали автомобиля</h1>

        @if($car)
            <p><strong>Бренд:</strong> {{ $car->brand->name ?? 'Н/Д' }}</p>
            <p><strong>Модель:</strong> {{ $car->model->name ?? 'Н/Д' }}</p>
            <p><strong>Год:</strong> {{ $car->year ?? 'Н/Д' }}</p>
            <p><strong>VIN:</strong> {{ $car->vin ?? 'Н/Д' }}</p>
            <p><strong>Цена:</strong> {{ number_format($car->price ?? 0, 2) }} ₽</p>
            <p><strong>Статус:</strong> {{ $car->status->name ?? 'Н/Д' }}</p>
            <p><strong>Салон:</strong> {{ $car->salon->name ?? 'Н/Д' }}</p>
            <p><strong>Описание:</strong> {{ $car->description ?? 'Н/Д' }}</p>
            <p><strong>Опции:</strong>
                @php
                    $optionsList = $car->options
                        ? array_map('trim', explode(',', $car->options))
                        : [];
                @endphp
                @forelse($optionsList as $option)
                    <span class="badge bg-secondary">{{ $option }}</span>
                @empty
                    Нет опций
                @endforelse
            </p>
            <a href="{{ route('cars.index') }}" class="btn btn-primary mt-3">Назад к списку</a>
        @else
            <p>Автомобиль не найден.</p>
        @endif
    </div>
@endsection