<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Deal;
use App\Models\Car;
use App\Models\Client;
use App\Models\Employee;

class DealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $cars = Car::all();
        $clients = Client::all();
        $employees = Employee::all();

        if ($cars->isEmpty() || $clients->isEmpty() || $employees->isEmpty()) {
            $this->command->info('Не найдены необходимые данные для создания сделок.');
            return;
        }

        $types = ['sale', 'repair'];

        // Создадим 20 сделок
        for ($i = 0; $i < 20; $i++) {
            $car = $cars->random();
            $client = $clients->random();
            $employee = $employees->random();
            $type = $types[array_rand($types)];

            Deal::create([
                'car_id' => $car->id,
                'client_id' => $client->id,
                'employee_id' => $employee->id,
                'type' => $type,
                'amount' => $type === 'sale' ? $car->price : rand(10000, 100000),
                'description' => 'Тестовая сделка #' . ($i + 1),
                'date' => now()->subDays(rand(1, 30)),
            ]);
        }

        $this->command->info('Сделки успешно созданы!');
    }
} 