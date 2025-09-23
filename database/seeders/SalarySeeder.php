<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Salary;
use App\Models\Employee;

class SalarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $employees = Employee::all();

        if ($employees->isNotEmpty()) {
            foreach ($employees as $employee) {
                // Create salary records for the last 3 months
                for ($i = 0; $i < 3; $i++) {
                    Salary::create([
                        'employee_id' => $employee->id,
                        'payment_date' => now()->subMonths($i)->startOfMonth(),
                        'amount' => $employee->jobTitle ? $employee->jobTitle->daily_salary : 0,
                        'description' => 'Monthly salary'
                    ]);
                }
            }
        }
    }
} 