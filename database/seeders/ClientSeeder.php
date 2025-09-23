<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            [
                'last_name' => 'Иванов',
                'first_name' => 'Иван',
                'middle_name' => 'Иванович',
                'phone' => '89991112233',
                'email' => 'ivanov@example.com',
                'password' => Hash::make('password'),
                'address' => 'ул. Ленина, 1',
                'passport' => '1234 567890'
            ],
            [
                'last_name' => 'Петров',
                'first_name' => 'Петр',
                'middle_name' => 'Петрович',
                'phone' => '89991112234',
                'email' => 'petrov@example.com',
                'password' => Hash::make('password'),
                'address' => 'ул. Пушкина, 2',
                'passport' => '2345 678901'
            ],
            [
                'last_name' => 'Сидоров',
                'first_name' => 'Сидор',
                'middle_name' => 'Сидорович',
                'phone' => '89991112235',
                'email' => 'sidorov@example.com',
                'password' => Hash::make('password'),
                'address' => 'ул. Гагарина, 3',
                'passport' => '3456 789012'
            ]
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }

        $this->command->info('Клиенты успешно созданы!');
    }
} 