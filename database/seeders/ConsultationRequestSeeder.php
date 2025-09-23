<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConsultationRequest;
use App\Models\Client;
use App\Models\Cars;
use Carbon\Carbon;

class ConsultationRequestSeeder extends Seeder
{
    public function run(): void
    {
        $clients = Client::all();
        $cars = Cars::all();

        if ($clients->isEmpty() || $cars->isEmpty()) {
            $this->command->info('Не найдены клиенты или автомобили для создания заявок на консультацию.');
            return;
        }

        $statuses = ['pending', 'processed', 'completed', 'cancelled'];

        for ($i = 0; $i < 20; $i++) {
            $client = $clients->random();
            $car = $cars->random();
            $status = $statuses[array_rand($statuses)];

            ConsultationRequest::create([
                'user_id' => $client->id,
                'car_id' => $car->id,
                'scheduled_at' => Carbon::now()->addDays(rand(1, 10))->setTime(rand(9, 17), 0, 0),
                'status' => $status,
                'notes' => 'Тестовая заявка на консультацию о ' . $car->brand->name . ' ' . $car->model->name,
            ]);
        }

        $this->command->info('Заявки на консультацию успешно созданы!');
    }
} 