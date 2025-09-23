@extends('layouts.app')

@section('content')
<form id="createCarStatusForm" method="POST" action="{{ route('admin.car-statuses.store') }}">
    @csrf
    <div class="mb-3">
        <label for="Название_статуса" class="form-label">Название статуса</label>
        <input type="text" class="form-control" id="Название_статуса" name="Название_статуса" required>
    </div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>
@endsection 