<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class UpdateAdminPasswordCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:admin-password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the password for the admin user.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $adminEmployee = Employee::where('email', 'admin@example.com')->first();

        if ($adminEmployee) {
            $adminEmployee->Пароль = Hash::make('password1'); // Используйте нужный пароль
            $adminEmployee->save();
            $this->info('Пароль администратора успешно обновлен.');
        } else {
            $this->error('Сотрудник с email admin@example.com не найден.');
        }
    }
}
