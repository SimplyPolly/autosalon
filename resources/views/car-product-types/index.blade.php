@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Типы автотоваров</h3>
            @auth('employee')
                @if($employee && $employee->jobTitle && $employee->jobTitle->title === 'Администратор')
                    <a href="{{ route('admin.car-product-types.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Добавить новый тип
                    </a>
                @endif
            @endauth
        </div>
        <div class="card-body">
            @if(isset($carProductTypes) && $carProductTypes->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Название типа</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($carProductTypes as $type)
                            <tr>
                                <td>{{ $type->id }}</td>
                                <td>{{ $type->name }}</td>
                                <td>
                                    <a href="{{ route('admin.car-product-types.show', $type->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Подробнее
                                    </a>
                                    @auth('employee')
                                        @if($employee && $employee->jobTitle && $employee->jobTitle->title === 'Администратор')
                                            <a href="{{ route('admin.car-product-types.edit', $type->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Изменить
                                            </a>
                                            <form action="{{ route('admin.car-product-types.destroy', $type->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены?')">
                                                    <i class="fas fa-trash"></i> Удалить
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Типы автотоваров не найдены.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection