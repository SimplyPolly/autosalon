<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarBrands;

class CarBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'Toyota', 'country' => 'Japan'],
            ['name' => 'Honda', 'country' => 'Japan'],
            ['name' => 'BMW', 'country' => 'Germany'],
            ['name' => 'Mercedes-Benz', 'country' => 'Germany'],
            ['name' => 'Audi', 'country' => 'Germany'],
            ['name' => 'Volkswagen', 'country' => 'Germany'],
            ['name' => 'Ford', 'country' => 'USA'],
            ['name' => 'Chevrolet', 'country' => 'USA'],
            ['name' => 'Hyundai', 'country' => 'South Korea'],
            ['name' => 'Kia', 'country' => 'South Korea'],
        ];

        foreach ($brands as $brand) {
            CarBrands::create($brand);
        }

        $this->command->info('Бренды авто успешно добавлены.');
    }
} 