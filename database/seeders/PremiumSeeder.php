<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Premium;
use App\Models\Employee;

class PremiumSeeder extends Seeder
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
                // Create premium records for the last 3 months
                for ($i = 0; $i < 3; $i++) {
                    Premium::create([
                        'employee_id' => $employee->id,
                        'payment_date' => now()->subMonths($i)->endOfMonth(),
                        'amount' => $employee->salary * 0.2, // 20% of salary
                        'description' => 'Monthly premium'
                    ]);
                }
            }
        }
    }
} 