<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use App\Models\JobTitle;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $mechanicJob = JobTitle::where('title', 'Механик')->first();
        $mechanicJobId = $mechanicJob ? $mechanicJob->id : 3;

        $employees = [
            [
                'salon_id' => 1,
                'last_name' => 'Админов',
                'first_name' => 'Админ',
                'middle_name' => 'Админович',
                'phone' => '89991112233',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'job_title_id' => 1 // Администратор
            ],
            [
                'salon_id' => 1,
                'last_name' => 'Иванов',
                'first_name' => 'Иван',
                'middle_name' => 'Иванович',
                'phone' => '89991112234',
                'email' => 'ivanov@example.com',
                'password' => Hash::make('password'),
                'job_title_id' => 2 // Менеджер
            ],
            [
                'salon_id' => 1,
                'last_name' => 'Петров',
                'first_name' => 'Петр',
                'middle_name' => 'Петрович',
                'phone' => '89991112235',
                'email' => 'petrov@example.com',
                'password' => Hash::make('password'),
                'job_title_id' => $mechanicJobId // Механик
            ],
            [
                'salon_id' => 1,
                'last_name' => 'Сидоров',
                'first_name' => 'Сидор',
                'middle_name' => 'Сидорович',
                'phone' => '89991112236',
                'email' => 'sidorov@example.com',
                'password' => Hash::make('password'),
                'job_title_id' => 4 // Продавец
            ]
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }

        $this->command->info('Employees created successfully.');
    }
} 