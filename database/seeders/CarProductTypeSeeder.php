<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarProductType;

class CarProductTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Запчасти'],
            ['name' => 'Масла'],
            ['name' => 'Фильтры'],
            ['name' => 'Аксессуары'],
            ['name' => 'Шины'],
            ['name' => 'Автохимия']
        ];

        $this->command->info('Авто проудкты добавлены успешно.');
    }
}