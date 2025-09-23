<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarProducts;
use App\Models\CarProductType;

class CarProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $types = CarProductType::all();
        
        if ($types->isEmpty()) {
            $types = CarProductType::create([
                'name' => 'Запчасти',
                'description' => 'Запасные части для автомобилей'
            ]);
        }

        $products = [
            [
                'name' => 'Масло моторное 5W-30',
                'type_id' => $types->first()->id,
                'description' => 'Синтетическое моторное масло 5W-30, 4л',
                'price' => 2500.00,
                'quantity' => 50
            ],
            [
                'name' => 'Масляный фильтр',
                'type_id' => $types->first()->id,
                'description' => 'Масляный фильтр универсальный',
                'price' => 500.00,
                'quantity' => 100
            ],
            [
                'name' => 'Воздушный фильтр',
                'type_id' => $types->first()->id,
                'description' => 'Воздушный фильтр салона',
                'price' => 800.00,
                'quantity' => 75
            ],
            [
                'name' => 'Тормозные колодки',
                'type_id' => $types->first()->id,
                'description' => 'Передние тормозные колодки',
                'price' => 3500.00,
                'quantity' => 30
            ],
            [
                'name' => 'Аккумулятор',
                'type_id' => $types->first()->id,
                'description' => 'Аккумулятор 60А/ч',
                'price' => 8000.00,
                'quantity' => 20
            ]
        ];

        foreach ($products as $product) {
            CarProducts::create($product);
        }
    }
} 