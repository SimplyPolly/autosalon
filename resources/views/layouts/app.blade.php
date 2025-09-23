<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Автосалон') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            margin-bottom: 20px;
        }
        .content-wrapper {
            padding: 20px;
        }
        .table-container {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        /* Временные стили для отладки выпадающих меню - СИЛЬНОЕ ПРИНУЖДЕНИЕ */
        .dropdown-menu.show {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
            position: absolute !important;
            top: 100% !important; /* Позиционирование ниже кнопки */
            left: 0 !important; /* Выравнивание по левому краю */
            z-index: 9999 !important; /* Убедимся, что меню находится поверх всего */
            background-color: white !important; /* Явный фон */
            border: 1px solid #ccc !important; /* Явная граница */
            min-width: 10rem !important; /* Минимальная ширина */
        }

        {{-- /* Временные стили для отладки выпадающих меню */ --}}
        {{-- .dropdown-menu.show {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
        } --}}

        {{-- .nav-link.dropdown-toggle {
            z-index: 10000 !important; /* Очень высокий z-index */
            background-color: rgba(255, 0, 0, 0.3) !important; /* Временный красный фон для видимости */
        } --}}
    </style>
</head>
<body class="font-sans antialiased">
    <div id="app">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            console.log('jQuery DOM готов. Инициализация выпадающих меню...');
            
            // Инициализация всех выпадающих меню Bootstrap
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
            var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl);
            });
            
            console.log('Выпадающие меню Bootstrap инициализированы через jQuery.');
        });
    </script>

    @stack('scripts')
</body>
</html>