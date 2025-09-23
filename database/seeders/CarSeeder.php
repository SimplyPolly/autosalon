<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cars;
use App\Models\CarBrands;
use App\Models\CarModels;
use App\Models\CarStatus;
use App\Models\Salon;

class CarSeeder extends Seeder
{
    public function run()
    {
        $brands = CarBrands::all();
        $models = CarModels::all();
        $statuses = CarStatus::all();
        $salons = Salon::all();

        if ($brands->isEmpty() || $models->isEmpty() || $statuses->isEmpty() || $salons->isEmpty()) {
            $this->command->info('Не найдены необходимые справочники для автомобилей.');
            return;
        }

        for ($i = 0; $i < 20; $i++) {
            $brand = $brands->random();

            $model = $models->where('brand_id', $brand->id)->random();

            $status = $statuses->random();
            $salon = $salons->random();

            $vinNumber = 'VIN' . str_pad($i, 6, '0', STR_PAD_LEFT);
            $registrationNumber = 'A' . rand(100, 999) . 'BC' . rand(10, 99);
            $year = rand(2010, 2023);
            $color = ['White', 'Black', 'Blue', 'Red', 'Grey', 'Silver', 'Green'][rand(0,6)];
            $price = rand(500000, 3000000);
            $mileage = rand(0, 200000);
            $description = 'Тестовый автомобиль ' . $brand->name . ' ' . $model->name;

            $car = Cars::create([
                'salon_id' => $salon->id,
                'brand_id' => $brand->id,
                'model_id' => $model->id,
                'status_id' => $status->id,
                'vin' => $vinNumber,
                'registration_number' => $registrationNumber,
                'year' => $year,
                'color' => $color,
                'price' => $price,
                'mileage' => $mileage,
                'description' => $description,
                'car_option' => '', 
            ]);

        }

        $this->command->info('Автомобили успешно созданы!');
    }
}