<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Clients;
use Illuminate\Support\Facades\Hash;

try {
    $user = Clients::firstOrCreate(
        ['email' => 'test@example.com'],
        [
            'Фамилия' => 'Тестовый',
            'Имя' => 'Клиент',
            'Телефон' => '1234567890',
            'Пароль' => Hash::make('password'),
            'Адрес' => 'Тестовый адрес',
        ]
    );

    if ($user->wasRecentlyCreated) {
        echo "Тестовый пользователь test@example.com создан успешно.\n";
    } else {
        echo "Тестовый пользователь test@example.com уже существует.\n";
    }
} catch (\Exception $e) {
    echo "Ошибка при создании пользователя: " . $e->getMessage() . "\n";
} 