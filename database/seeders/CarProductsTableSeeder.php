<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('car_products')->insert([
            ['salon_id' => 1, 'product_type_id' => 1, 'name' => 'Summer Tires 205/55R16', 'price' => 80, 'stock' => 20, 'description' => 'Summer tires for compact cars'],
            ['salon_id' => 2, 'product_type_id' => 2, 'name' => 'Car Battery 60Ah', 'price' => 120, 'stock' => 15, 'description' => 'Standard car battery'],
            ['salon_id' => 3, 'product_type_id' => 3, 'name' => 'Synthetic Oil 5W-30', 'price' => 40, 'stock' => 30, 'description' => 'Synthetic engine oil'],
            ['salon_id' => 4, 'product_type_id' => 4, 'name' => 'Air Filter', 'price' => 15, 'stock' => 25, 'description' => 'Standard air filter'],
            ['salon_id' => 5, 'product_type_id' => 5, 'name' => 'Brake Pads Front', 'price' => 50, 'stock' => 10, 'description' => 'Front brake pads'],
            ['salon_id' => 6, 'product_type_id' => 6, 'name' => 'Windshield Wipers', 'price' => 20, 'stock' => 40, 'description' => 'Universal wipers'],
            ['salon_id' => 7, 'product_type_id' => 7, 'name' => 'LED Headlight Bulbs', 'price' => 60, 'stock' => 12, 'description' => 'LED replacement bulbs'],
            ['salon_id' => 8, 'product_type_id' => 8, 'name' => 'Car Cover', 'price' => 35, 'stock' => 8, 'description' => 'Universal car cover'],
            ['salon_id' => 9, 'product_type_id' => 9, 'name' => 'Bluetooth Adapter', 'price' => 25, 'stock' => 18, 'description' => 'Bluetooth adapter for older cars'],
            ['salon_id' => 10, 'product_type_id' => 10, 'name' => 'Tool Set', 'price' => 100, 'stock' => 5, 'description' => 'Basic automotive tool set'],
        ]);
    }
}
