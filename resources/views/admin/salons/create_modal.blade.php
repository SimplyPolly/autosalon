@extends('layouts.app')

@section('content')
<form id="createSalonForm" method="POST" action="{{ route('admin.salons.store') }}">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Название салона</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Адрес</label>
        <input type="text" class="form-control" id="address" name="address" required>
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Телефон</label>
        <input type="text" class="form-control" id="phone" name="phone" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>
@endsection 