<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('car_statuses')->insert([
            ['name' => 'Available'],
            ['name' => 'Sold'],
            ['name' => 'Reserved'],
            ['name' => 'In Service'],
            ['name' => 'On Test Drive'],
            ['name' => 'Awaiting Parts'],
            ['name' => 'Under Repair'],
            ['name' => 'Returned'],
            ['name' => 'Written Off'],
            ['name' => 'Transferred'],
        ]);
    }
}
