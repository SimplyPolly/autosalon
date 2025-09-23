<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('clients')->insert([
            ['last_name' => 'Smith', 'first_name' => 'John', 'middle_name' => 'A.', 'passport' => 'AB1234567', 'phone' => '+1111111111', 'email' => 'john.smith@example.com', 'password' => bcrypt('password'), 'address' => '1 Main St', 'remember_token' => null],
            ['last_name' => 'Johnson', 'first_name' => 'Emily', 'middle_name' => 'B.', 'passport' => 'CD2345678', 'phone' => '+1111111112', 'email' => 'emily.johnson@example.com', 'password' => bcrypt('password'), 'address' => '2 Main St', 'remember_token' => null],
            ['last_name' => 'Williams', 'first_name' => 'Michael', 'middle_name' => 'C.', 'passport' => 'EF3456789', 'phone' => '+1111111113', 'email' => 'michael.williams@example.com', 'password' => bcrypt('password'), 'address' => '3 Main St', 'remember_token' => null],
            ['last_name' => 'Brown', 'first_name' => 'Sarah', 'middle_name' => 'D.', 'passport' => 'GH4567890', 'phone' => '+1111111114', 'email' => 'sarah.brown@example.com', 'password' => bcrypt('password'), 'address' => '4 Main St', 'remember_token' => null],
            ['last_name' => 'Jones', 'first_name' => 'David', 'middle_name' => 'E.', 'passport' => 'IJ5678901', 'phone' => '+1111111115', 'email' => 'david.jones@example.com', 'password' => bcrypt('password'), 'address' => '5 Main St', 'remember_token' => null],
            ['last_name' => 'Garcia', 'first_name' => 'Maria', 'middle_name' => 'F.', 'passport' => 'KL6789012', 'phone' => '+1111111116', 'email' => 'maria.garcia@example.com', 'password' => bcrypt('password'), 'address' => '6 Main St', 'remember_token' => null],
            ['last_name' => 'Martinez', 'first_name' => 'James', 'middle_name' => 'G.', 'passport' => 'MN7890123', 'phone' => '+1111111117', 'email' => 'james.martinez@example.com', 'password' => bcrypt('password'), 'address' => '7 Main St', 'remember_token' => null],
            ['last_name' => 'Davis', 'first_name' => 'Linda', 'middle_name' => 'H.', 'passport' => 'OP8901234', 'phone' => '+1111111118', 'email' => 'linda.davis@example.com', 'password' => bcrypt('password'), 'address' => '8 Main St', 'remember_token' => null],
            ['last_name' => 'Rodriguez', 'first_name' => 'Robert', 'middle_name' => 'I.', 'passport' => 'QR9012345', 'phone' => '+1111111119', 'email' => 'robert.rodriguez@example.com', 'password' => bcrypt('password'), 'address' => '9 Main St', 'remember_token' => null],
            ['last_name' => 'Miller', 'first_name' => 'Patricia', 'middle_name' => 'J.', 'passport' => 'ST0123456', 'phone' => '+1111111120', 'email' => 'patricia.miller@example.com', 'password' => bcrypt('password'), 'address' => '10 Main St', 'remember_token' => null],
        ]);
    }
}
