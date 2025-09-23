<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\JobTitle;
use App\Models\Salon;
use App\Models\Clients;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Создаем базовые сущности, от которых зависят другие сидеры

        // Создаем должности
        $adminRole = JobTitle::create([
            'title' => 'Администратор',
            'daily_salary' => 5000.00
        ]);

        $managerRole = JobTitle::create([
            'title' => 'Менеджер',
            'daily_salary' => 3000.00
        ]);

        // Создаем салон
        $salon = Salon::create([
            'name' => 'Главный салон',
            'address' => 'ул. Примерная, 1',
            'phone' => '89991234567'
        ]);

        // Создаем тестового клиента (удалено, будет в ClientSeeder)
        // Clients::create([
        //     'last_name' => 'Клиентов',
        //     'first_name' => 'Клиент',
        //     'middle_name' => 'Клиентович',
        //     'passport' => '1234 567890',
        //     'phone' => '89997778899',
        //     'email' => 'client@example.com',
        //     'password' => Hash::make('client123'),
        //     'address' => 'ул. Клиентская, 1'
        // ]);

        // Вызываем сидеры в порядке зависимостей
        $this->call([
            JobTitleSeeder::class,      // Должности
            SalonSeeder::class,         // Салоны
            EmployeeSeeder::class,      // Сотрудники
            ClientSeeder::class,        // Клиенты
            CarBrandSeeder::class,      // Бренды автомобилей
            CarModelSeeder::class,      // Модели автомобилей
            CarStatusSeeder::class,     // Статусы автомобилей
            CarOptionsTableSeeder::class, // Добавлено: Опции автомобилей
            CarProductTypeSeeder::class,// Типы автотоваров
            CarSeeder::class,           // Автомобили
            CarProductSeeder::class,    // Автотовары
            DealSeeder::class,          // Сделки
            RepairWorkSeeder::class,    // Ремонтные работы
            SalarySeeder::class,        // Зарплаты
            PremiumSeeder::class,       // Премии
            ConsultationRequestSeeder::class, // Заявки на консультацию
        ]);
    }
}
