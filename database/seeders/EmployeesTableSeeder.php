<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('employees')->insert([
            ['last_name' => 'Taylor', 'first_name' => 'Olivia', 'middle_name' => 'K.', 'phone' => '+1222333444', 'email' => 'olivia.taylor@example.com', 'password' => bcrypt('password'), 'job_title_id' => 1, 'salon_id' => 1],
            ['last_name' => 'Anderson', 'first_name' => 'Liam', 'middle_name' => 'L.', 'phone' => '+1222333445', 'email' => 'liam.anderson@example.com', 'password' => bcrypt('password'), 'job_title_id' => 2, 'salon_id' => 2],
            ['last_name' => 'Thomas', 'first_name' => 'Sophia', 'middle_name' => 'M.', 'phone' => '+1222333446', 'email' => 'sophia.thomas@example.com', 'password' => bcrypt('password'), 'job_title_id' => 3, 'salon_id' => 3],
            ['last_name' => 'Jackson', 'first_name' => 'Mason', 'middle_name' => 'N.', 'phone' => '+1222333447', 'email' => 'mason.jackson@example.com', 'password' => bcrypt('password'), 'job_title_id' => 4, 'salon_id' => 4],
            ['last_name' => 'White', 'first_name' => 'Ava', 'middle_name' => 'O.', 'phone' => '+1222333448', 'email' => 'ava.white@example.com', 'password' => bcrypt('password'), 'job_title_id' => 5, 'salon_id' => 5],
            ['last_name' => 'Harris', 'first_name' => 'Lucas', 'middle_name' => 'P.', 'phone' => '+1222333449', 'email' => 'lucas.harris@example.com', 'password' => bcrypt('password'), 'job_title_id' => 6, 'salon_id' => 6],
            ['last_name' => 'Martin', 'first_name' => 'Mia', 'middle_name' => 'Q.', 'phone' => '+1222333450', 'email' => 'mia.martin@example.com', 'password' => bcrypt('password'), 'job_title_id' => 7, 'salon_id' => 7],
            ['last_name' => 'Lee', 'first_name' => 'Ethan', 'middle_name' => 'R.', 'phone' => '+1222333451', 'email' => 'ethan.lee@example.com', 'password' => bcrypt('password'), 'job_title_id' => 8, 'salon_id' => 8],
            ['last_name' => 'Perez', 'first_name' => 'Charlotte', 'middle_name' => 'S.', 'phone' => '+1222333452', 'email' => 'charlotte.perez@example.com', 'password' => bcrypt('password'), 'job_title_id' => 9, 'salon_id' => 9],
            ['last_name' => 'Clark', 'first_name' => 'Benjamin', 'middle_name' => 'T.', 'phone' => '+1222333453', 'email' => 'benjamin.clark@example.com', 'password' => bcrypt('password'), 'job_title_id' => 10, 'salon_id' => 10],
        ]);
    }
}
