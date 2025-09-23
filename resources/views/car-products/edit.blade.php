@extends('layouts.app')

@section('title', 'Редактировать автотовар')

@section('content')
<div class="container">
    <h2>Редактировать автотовар</h2>
    <form method="POST" action="{{ route('admin.car-products.update', $product->id) }}" id="editForm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Название</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Описание</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Цена</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ old('price', $product->price) }}" required>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Количество</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}" required>
        </div>

        <div class="mb-3">
            <label for="type_id" class="form-label">Тип товара</label>
            <select class="form-select" id="type_id" name="type_id" required>
                @foreach($productTypes as $type)
                    <option value="{{ $type->id }}" {{ $product->type_id == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ route('car-products.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>

@push('scripts')
<script>
document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = '{{ route("car-products.index") }}';
        } else {
            alert('Ошибка при обновлении товара: ' + (data.message || 'Неизвестная ошибка'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Произошла ошибка при отправке данных');
    });
});
</script>
@endpush
@endsection 