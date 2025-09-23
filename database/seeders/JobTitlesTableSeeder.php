<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobTitlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('job_titles')->insert([
            ['title' => 'Manager', 'daily_salary' => 150],
            ['title' => 'Salesperson', 'daily_salary' => 100],
            ['title' => 'Mechanic', 'daily_salary' => 120],
            ['title' => 'Accountant', 'daily_salary' => 130],
            ['title' => 'Receptionist', 'daily_salary' => 90],
            ['title' => 'Security', 'daily_salary' => 80],
            ['title' => 'Cleaner', 'daily_salary' => 70],
            ['title' => 'IT Specialist', 'daily_salary' => 140],
            ['title' => 'HR Specialist', 'daily_salary' => 110],
            ['title' => 'Driver', 'daily_salary' => 95],
        ]);
    }
}
