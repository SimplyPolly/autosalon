<!-- Primary Navigation Menu -->
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Автосалон') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cars.index') }}">{{ __('Автомобили') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/car-products') }}">{{ __('Автотовары') }}</a>
                </li>

                @auth('employee')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('employee.consultation-requests.index') }}">{{ __('Заявки на консультацию') }}</a>
                    </li>
                    @php
                        $employee = Auth::guard('employee')->user();
                    @endphp
                    @if($employee && $employee->jobTitle && in_array($employee->jobTitle->title, ['Администратор', 'Administrator']))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownManagement" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ __('Управление') }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownManagement">
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Админ-панель</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('admin.employees.index') }}">{{ __('Сотрудники') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.salaries.index') }}">{{ __('Зарплаты') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.premiums.index') }}">{{ __('Премии') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.salons.index') }}">{{ __('Салоны') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.job-titles.index') }}">{{ __('Должности') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.car-brands.index') }}">{{ __('Бренды автомобилей') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.car-models.index') }}">{{ __('Модели автомобилей') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.car-options.index') }}">{{ __('Опции автомобилей') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.car-statuses.index') }}">{{ __('Статусы автомобилей') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.car-product-types.index') }}">{{ __('Типы автотоваров') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">{{ __('Пользователи') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('repair-works.index') }}">{{ __('Ремонтные работы') }}</a></li>
                            </ul>
                        </li>
                        @if(Auth::guard('employee')->check())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="reportsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ __('Отчеты') }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="reportsDropdown">
                                <li><a class="dropdown-item" href="{{ route('admin.reports.sales') }}">{{ __('Отчет по продажам') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.reports.repairs') }}">{{ __('Отчет по ремонтам') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.reports.salary') }}">{{ __('Отчет по зарплатам') }}</a></li>
                            </ul>
                        </li>
                        @endif
                    @endif
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Войти') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Регистрация') }}</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ Auth::guard('employee')->check() ? route('employee.dashboard') : route('dashboard') }}">
                            {{ Auth::guard('employee')->check() ? Auth::guard('employee')->user()->first_name . ' ' . Auth::guard('employee')->user()->last_name : Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('Выйти') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav> 