@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Личный кабинет') }}</div>

                <div class="card-body">
                    <h4>Добро пожаловать, {{ Auth::user()->Имя }} {{ Auth::user()->Фамилия }}!</h4>
                    
                    <div class="mt-4">
                        <h5>Ваши данные:</h5>
                        <ul class="list-unstyled">
                            <li><strong>Email:</strong> {{ Auth::user()->email }}</li>
                            <li><strong>Телефон:</strong> {{ Auth::user()->Телефон }}</li>
                            <li><strong>Адрес:</strong> {{ Auth::user()->Адрес }}</li>
                        </ul>
                    </div>

                    <div class="mt-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                {{ __('Выйти') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 