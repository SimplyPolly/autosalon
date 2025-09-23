<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarModels;
use App\Models\CarBrands;

class CarModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $models = [
            'Toyota' => [
                ['name' => 'Camry', 'carcass' => 'Sedan', 'engine' => '2.5L', 'engine_capacity' => 2.5],
                ['name' => 'Corolla', 'carcass' => 'Hatchback', 'engine' => '1.8L', 'engine_capacity' => 1.8],
                ['name' => 'RAV4', 'carcass' => 'SUV', 'engine' => '2.0L', 'engine_capacity' => 2.0],
                ['name' => 'Land Cruiser', 'carcass' => 'SUV', 'engine' => '4.0L', 'engine_capacity' => 4.0],
                ['name' => 'Prius', 'carcass' => 'Hatchback', 'engine' => '1.8L Hybrid', 'engine_capacity' => 1.8],
            ],
            'Honda' => [
                ['name' => 'Civic', 'carcass' => 'Sedan', 'engine' => '2.0L', 'engine_capacity' => 2.0],
                ['name' => 'Accord', 'carcass' => 'Sedan', 'engine' => '2.4L', 'engine_capacity' => 2.4],
                ['name' => 'CR-V', 'carcass' => 'SUV', 'engine' => '2.0L', 'engine_capacity' => 2.0],
                ['name' => 'Pilot', 'carcass' => 'SUV', 'engine' => '3.5L', 'engine_capacity' => 3.5],
                ['name' => 'Odyssey', 'carcass' => 'Minivan', 'engine' => '3.5L', 'engine_capacity' => 3.5],
            ],
            'BMW' => [
                ['name' => '3 Series', 'carcass' => 'Sedan', 'engine' => '3.0L', 'engine_capacity' => 3.0],
                ['name' => '5 Series', 'carcass' => 'Sedan', 'engine' => '3.0L', 'engine_capacity' => 3.0],
                ['name' => 'X5', 'carcass' => 'SUV', 'engine' => '3.0L', 'engine_capacity' => 3.0],
                ['name' => 'X3', 'carcass' => 'SUV', 'engine' => '2.0L', 'engine_capacity' => 2.0],
                ['name' => '7 Series', 'carcass' => 'Sedan', 'engine' => '4.4L', 'engine_capacity' => 4.4],
            ],
            'Mercedes-Benz' => [
                ['name' => 'C-Class', 'carcass' => 'Sedan', 'engine' => '2.0L', 'engine_capacity' => 2.0],
                ['name' => 'E-Class', 'carcass' => 'Sedan', 'engine' => '2.5L', 'engine_capacity' => 2.5],
                ['name' => 'S-Class', 'carcass' => 'Sedan', 'engine' => '3.0L', 'engine_capacity' => 3.0],
                ['name' => 'GLC', 'carcass' => 'SUV', 'engine' => '2.0L', 'engine_capacity' => 2.0],
                ['name' => 'GLE', 'carcass' => 'SUV', 'engine' => '3.0L', 'engine_capacity' => 3.0],
            ],
            'Audi' => [
                ['name' => 'A4', 'carcass' => 'Sedan', 'engine' => '2.0L', 'engine_capacity' => 2.0],
                ['name' => 'A6', 'carcass' => 'Sedan', 'engine' => '2.5L', 'engine_capacity' => 2.5],
                ['name' => 'Q5', 'carcass' => 'SUV', 'engine' => '2.0L', 'engine_capacity' => 2.0],
                ['name' => 'Q7', 'carcass' => 'SUV', 'engine' => '3.0L', 'engine_capacity' => 3.0],
                ['name' => 'A8', 'carcass' => 'Sedan', 'engine' => '3.0L', 'engine_capacity' => 3.0],
            ],
            'Volkswagen' => [
                ['name' => 'Passat', 'carcass' => 'Sedan', 'engine' => '1.8L', 'engine_capacity' => 1.8],
                ['name' => 'Golf', 'carcass' => 'Hatchback', 'engine' => '1.4L', 'engine_capacity' => 1.4],
                ['name' => 'Tiguan', 'carcass' => 'SUV', 'engine' => '2.0L', 'engine_capacity' => 2.0],
                ['name' => 'Touareg', 'carcass' => 'SUV', 'engine' => '3.0L', 'engine_capacity' => 3.0],
                ['name' => 'Polo', 'carcass' => 'Hatchback', 'engine' => '1.6L', 'engine_capacity' => 1.6],
            ],
            'Ford' => [
                ['name' => 'Focus', 'carcass' => 'Hatchback', 'engine' => '1.6L', 'engine_capacity' => 1.6],
                ['name' => 'Mustang', 'carcass' => 'Coupe', 'engine' => '5.0L', 'engine_capacity' => 5.0],
                ['name' => 'Explorer', 'carcass' => 'SUV', 'engine' => '3.5L', 'engine_capacity' => 3.5],
                ['name' => 'F-150', 'carcass' => 'Pickup', 'engine' => '5.0L', 'engine_capacity' => 5.0],
                ['name' => 'Escape', 'carcass' => 'SUV', 'engine' => '1.5L', 'engine_capacity' => 1.5],
            ],
            'Chevrolet' => [
                ['name' => 'Malibu', 'carcass' => 'Sedan', 'engine' => '1.5L', 'engine_capacity' => 1.5],
                ['name' => 'Camaro', 'carcass' => 'Coupe', 'engine' => '6.2L', 'engine_capacity' => 6.2],
                ['name' => 'Tahoe', 'carcass' => 'SUV', 'engine' => '5.3L', 'engine_capacity' => 5.3],
                ['name' => 'Silverado', 'carcass' => 'Pickup', 'engine' => '6.2L', 'engine_capacity' => 6.2],
                ['name' => 'Equinox', 'carcass' => 'SUV', 'engine' => '1.5L', 'engine_capacity' => 1.5],
            ],
            'Hyundai' => [
                ['name' => 'Sonata', 'carcass' => 'Sedan', 'engine' => '2.0L', 'engine_capacity' => 2.0],
                ['name' => 'Elantra', 'carcass' => 'Sedan', 'engine' => '1.6L', 'engine_capacity' => 1.6],
                ['name' => 'Tucson', 'carcass' => 'SUV', 'engine' => '2.0L', 'engine_capacity' => 2.0],
                ['name' => 'Santa Fe', 'carcass' => 'SUV', 'engine' => '2.4L', 'engine_capacity' => 2.4],
                ['name' => 'Accent', 'carcass' => 'Hatchback', 'engine' => '1.4L', 'engine_capacity' => 1.4],
            ],
            'Kia' => [
                ['name' => 'Optima', 'carcass' => 'Sedan', 'engine' => '2.0L', 'engine_capacity' => 2.0],
                ['name' => 'Sorento', 'carcass' => 'SUV', 'engine' => '2.2L', 'engine_capacity' => 2.2],
                ['name' => 'Sportage', 'carcass' => 'SUV', 'engine' => '2.0L', 'engine_capacity' => 2.0],
                ['name' => 'Rio', 'carcass' => 'Hatchback', 'engine' => '1.6L', 'engine_capacity' => 1.6],
                ['name' => 'Forte', 'carcass' => 'Sedan', 'engine' => '2.0L', 'engine_capacity' => 2.0],
            ],
        ];

        foreach ($models as $brandName => $brandModels) {
            $brand = CarBrands::where('name', $brandName)->first();
            if ($brand) {
                foreach ($brandModels as $model) {
                    $model['brand_id'] = $brand->id;
                    CarModels::create($model);
                }
            }
        }

        $this->command->info('Модели авто успешно добавлены.');
    }
} 