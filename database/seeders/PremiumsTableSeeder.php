<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PremiumsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('premiums')->insert([
            ['employee_id' => 1, 'amount' => 500, 'payment_date' => '2023-01-15'],
            ['employee_id' => 2, 'amount' => 400, 'payment_date' => '2023-01-15'],
            ['employee_id' => 3, 'amount' => 600, 'payment_date' => '2023-01-15'],
            ['employee_id' => 4, 'amount' => 450, 'payment_date' => '2023-01-15'],
            ['employee_id' => 5, 'amount' => 550, 'payment_date' => '2023-01-15'],
            ['employee_id' => 6, 'amount' => 350, 'payment_date' => '2023-01-15'],
            ['employee_id' => 7, 'amount' => 650, 'payment_date' => '2023-01-15'],
            ['employee_id' => 8, 'amount' => 300, 'payment_date' => '2023-01-15'],
            ['employee_id' => 9, 'amount' => 700, 'payment_date' => '2023-01-15'],
            ['employee_id' => 10, 'amount' => 250, 'payment_date' => '2023-01-15'],
        ]);
    }
}
