<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DealsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('deals')->insert([
            ['car_id' => 1, 'product_id' => null, 'client_id' => 1, 'employee_id' => 1, 'deal_date' => '2023-01-01 10:00:00', 'amount' => 20000, 'status' => 'Completed'],
            ['car_id' => null, 'product_id' => 1, 'client_id' => 2, 'employee_id' => 2, 'deal_date' => '2023-01-02 11:00:00', 'amount' => 80, 'status' => 'Completed'],
            ['car_id' => 2, 'product_id' => null, 'client_id' => 3, 'employee_id' => 3, 'deal_date' => '2023-01-03 12:00:00', 'amount' => 22000, 'status' => 'Completed'],
            ['car_id' => null, 'product_id' => 2, 'client_id' => 4, 'employee_id' => 4, 'deal_date' => '2023-01-04 13:00:00', 'amount' => 120, 'status' => 'Completed'],
            ['car_id' => 3, 'product_id' => null, 'client_id' => 5, 'employee_id' => 5, 'deal_date' => '2023-01-05 14:00:00', 'amount' => 15000, 'status' => 'Completed'],
            ['car_id' => null, 'product_id' => 3, 'client_id' => 6, 'employee_id' => 6, 'deal_date' => '2023-01-06 15:00:00', 'amount' => 40, 'status' => 'Completed'],
            ['car_id' => 4, 'product_id' => null, 'client_id' => 7, 'employee_id' => 7, 'deal_date' => '2023-01-07 16:00:00', 'amount' => 30000, 'status' => 'Completed'],
            ['car_id' => null, 'product_id' => 4, 'client_id' => 8, 'employee_id' => 8, 'deal_date' => '2023-01-08 17:00:00', 'amount' => 15, 'status' => 'Completed'],
            ['car_id' => 5, 'product_id' => null, 'client_id' => 9, 'employee_id' => 9, 'deal_date' => '2023-01-09 18:00:00', 'amount' => 50000, 'status' => 'Completed'],
            ['car_id' => null, 'product_id' => 5, 'client_id' => 10, 'employee_id' => 10, 'deal_date' => '2023-01-10 19:00:00', 'amount' => 50, 'status' => 'Completed'],
        ]);
    }
}
