<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'fullname' => 'Administrator',
            'contact' => '09495748302',
            'address' => '#83, Barangay Calingatan Mataasnakahoy Batangas',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'fullname' => 'Staff',
            'contact' => '09495748301',
            'address' => '#83, Barangay Bubuyan Mataasnakahoy Batangas',
            'email' => 'justinelance@gmail.com',
            'password' => Hash::make('123456789'),
            'role' => 'staff',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'fullname' => 'Customers',
            'contact' => '09495748302',
            'address' => '#83, Barangay Tambo Lipa City Batangas',
            'email' => 'jc@gmail.com',
            'password' => Hash::make('123456789'),
            'role' => 'customers',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
