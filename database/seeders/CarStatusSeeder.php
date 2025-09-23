<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarStatus;

class CarStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'В наличии'],
            ['name' => 'Зарезервирован'],
            ['name' => 'Продан'],
            ['name' => 'На ремонте'],
            ['name' => 'Списан']
        ];

        foreach ($statuses as $status) {
            CarStatus::create($status);
        }

        $this->command->info('Car statuses created successfully.');
    }
} 