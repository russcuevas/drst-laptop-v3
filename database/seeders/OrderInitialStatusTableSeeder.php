<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderInitialStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_initial_statuses')->insert([
            'initial_status' => 'Placed orders',
            'status_id' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('order_initial_statuses')->insert([
            'initial_status' => 'Placed orders',
            'status_id' => '2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
