<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RepairWork;
use App\Models\Car;
use App\Models\Employee;
use Carbon\Carbon;

class RepairWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Получаем все автомобили
        $cars = Car::all();
        
        // Получаем всех механиков
        $mechanics = Employee::whereHas('jobTitle', function($query) {
            $query->where('title', 'Механик');
        })->get();

        if ($mechanics->isEmpty()) {
            $this->command->info('Не найдены механики. Создайте сначала должности и сотрудников.');
            return;
        }

        if ($cars->isEmpty()) {
            $this->command->info('Не найдены автомобили. Создайте сначала автомобили.');
            return;
        }

        // Массив возможных описаний ремонтных работ
        $descriptions = [
            'Замена масла и фильтров',
            'Диагностика двигателя',
            'Ремонт тормозной системы',
            'Замена тормозных колодок',
            'Ремонт подвески',
            'Замена амортизаторов',
            'Ремонт коробки передач',
            'Замена сцепления',
            'Ремонт системы охлаждения',
            'Замена ремня ГРМ',
            'Ремонт электрики',
            'Замена аккумулятора',
            'Ремонт кондиционера',
            'Замена салонного фильтра',
            'Ремонт системы отопления'
        ];

        // Массив возможных статусов
        $statuses = ['pending', 'in_progress', 'completed'];

        // Создаем 50 ремонтных работ
        for ($i = 0; $i < 50; $i++) {
            $startDate = Carbon::now()->subDays(rand(0, 30));
            $status = $statuses[array_rand($statuses)];
            
            // Если статус "completed", добавляем дату завершения
            $endDate = $status === 'completed' 
                ? $startDate->copy()->addDays(rand(1, 5))
                : null;

            // Генерируем случайную стоимость от 5000 до 50000 рублей
            $cost = rand(5000, 50000);

            RepairWork::create([
                'car_id' => $cars->random()->id,
                'employee_id' => $mechanics->random()->id,
                'description' => $descriptions[array_rand($descriptions)],
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => $status,
                'cost' => $cost,
                'created_at' => $startDate,
                'updated_at' => $endDate ?? $startDate
            ]);
        }

        $this->command->info('Ремонтные работы успешно созданы!');
    }
} 