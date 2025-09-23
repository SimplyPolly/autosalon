@extends('layouts.app')

@section('content')
<form id="createBrandForm" method="POST" action="{{ route('admin.car-brands.store') }}">
    @csrf
    <div class="mb-3">
        <label for="Название_марки" class="form-label">Название бренда</label>
        <input type="text" class="form-control" id="Название_марки" name="Название_марки" required>
    </div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>
@endsection 