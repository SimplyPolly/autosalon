@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Добро пожаловать в Автосалон') }}</div>

                <div class="card-body">
                    <div class="text-center mb-4">
                        <h2>Наш автосалон предлагает:</h2>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Автомобили</h5>
                                    <p class="card-text">Широкий выбор новых и подержанных автомобилей различных марок и моделей.</p>
                                    <a href="{{ route('cars.index') }}" class="btn btn-primary">Перейти к каталогу</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Автотовары</h5>
                                    <p class="card-text">Большой ассортимент запчастей и аксессуаров для вашего автомобиля.</p>
                                    <a href="{{ route('car-products.index') }}" class="btn btn-primary">Перейти к товарам</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">О нас</h5>
                                    <p class="card-text">
                                        Мы - ведущий автосалон, предлагающий широкий спектр услуг:
                                    </p>
                                    <ul>
                                        <li>Продажа новых и подержанных автомобилей</li>
                                        <li>Сервисное обслуживание</li>
                                        <li>Продажа запчастей и аксессуаров</li>
                                        <li>Профессиональные консультации</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    @guest
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <a href="{{ route('login') }}" class="btn btn-primary btn-block w-100">Войти</a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('register') }}" class="btn btn-success btn-block w-100">Зарегистрироваться</a>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 