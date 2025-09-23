<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('salons')->insert([
            ['name' => 'AutoLux', 'address' => '123 Main St', 'phone' => '+1234567890'],
            ['name' => 'CarWorld', 'address' => '456 Elm St', 'phone' => '+1234567891'],
            ['name' => 'DriveTime', 'address' => '789 Oak St', 'phone' => '+1234567892'],
            ['name' => 'SpeedMotors', 'address' => '321 Maple Ave', 'phone' => '+1234567893'],
            ['name' => 'CityCars', 'address' => '654 Pine Ave', 'phone' => '+1234567894'],
            ['name' => 'UrbanAuto', 'address' => '987 Cedar Rd', 'phone' => '+1234567895'],
            ['name' => 'PrimeMotors', 'address' => '147 Spruce Rd', 'phone' => '+1234567896'],
            ['name' => 'AutoGalaxy', 'address' => '258 Birch Blvd', 'phone' => '+1234567897'],
            ['name' => 'CarPoint', 'address' => '369 Willow Dr', 'phone' => '+1234567898'],
            ['name' => 'MotorHub', 'address' => '159 Aspen Ln', 'phone' => '+1234567899'],
        ]);
    }
}
