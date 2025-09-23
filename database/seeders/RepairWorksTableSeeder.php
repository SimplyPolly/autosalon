<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RepairWorksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('repair_works')->insert([
            ['car_id' => 1, 'employee_id' => 1, 'description' => 'Oil change and filter replacement', 'start_date' => '2023-01-01 09:00:00', 'end_date' => '2023-01-01 10:00:00', 'status' => 'Completed'],
            ['car_id' => 2, 'employee_id' => 2, 'description' => 'Brake system inspection', 'start_date' => '2023-01-02 10:00:00', 'end_date' => '2023-01-02 11:00:00', 'status' => 'Completed'],
            ['car_id' => 3, 'employee_id' => 3, 'description' => 'Engine diagnostics', 'start_date' => '2023-01-03 11:00:00', 'end_date' => '2023-01-03 12:00:00', 'status' => 'Completed'],
            ['car_id' => 4, 'employee_id' => 4, 'description' => 'Transmission repair', 'start_date' => '2023-01-04 12:00:00', 'end_date' => '2023-01-04 13:00:00', 'status' => 'Completed'],
            ['car_id' => 5, 'employee_id' => 5, 'description' => 'Suspension check', 'start_date' => '2023-01-05 13:00:00', 'end_date' => '2023-01-05 14:00:00', 'status' => 'Completed'],
            ['car_id' => 6, 'employee_id' => 6, 'description' => 'Electrical system repair', 'start_date' => '2023-01-06 14:00:00', 'end_date' => '2023-01-06 15:00:00', 'status' => 'Completed'],
            ['car_id' => 7, 'employee_id' => 7, 'description' => 'Air conditioning service', 'start_date' => '2023-01-07 15:00:00', 'end_date' => '2023-01-07 16:00:00', 'status' => 'Completed'],
            ['car_id' => 8, 'employee_id' => 8, 'description' => 'Exhaust system repair', 'start_date' => '2023-01-08 16:00:00', 'end_date' => '2023-01-08 17:00:00', 'status' => 'Completed'],
            ['car_id' => 9, 'employee_id' => 9, 'description' => 'Bodywork repair', 'start_date' => '2023-01-09 17:00:00', 'end_date' => '2023-01-09 18:00:00', 'status' => 'Completed'],
            ['car_id' => 10, 'employee_id' => 10, 'description' => 'General maintenance', 'start_date' => '2023-01-10 18:00:00', 'end_date' => '2023-01-10 19:00:00', 'status' => 'Completed'],
        ]);
    }
}
