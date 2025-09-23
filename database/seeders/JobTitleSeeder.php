<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobTitle;

class JobTitleSeeder extends Seeder
{
    public function run(): void
    {
        $jobTitles = [
            ['title' => 'Администратор', 'daily_salary' => 5000],
            ['title' => 'Менеджер', 'daily_salary' => 4000],
            ['title' => 'Механик', 'daily_salary' => 3500],
            ['title' => 'Продавец', 'daily_salary' => 3000],
        ];

        foreach ($jobTitles as $jobTitle) {
            JobTitle::create($jobTitle);
        }

        $this->command->info('Job titles created successfully.');
    }
} 