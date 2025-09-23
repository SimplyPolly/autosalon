<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Salon;

class SalonSeeder extends Seeder
{
    public function run(): void
    {
        $salons = [
            [
                'name' => 'Главный салон',
                'address' => 'ул. Ленина, 1',
                'phone' => '8-800-123-45-67',
            ],
            [
                'name' => 'Филиал №1',
                'address' => 'ул. Пушкина, 10',
                'phone' => '8-800-123-45-68',
            ]
        ];

        foreach ($salons as $salon) {
            Salon::create($salon);
        }

        $this->command->info('Salons created successfully.');
    }
} 