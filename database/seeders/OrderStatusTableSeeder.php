<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_statuses')->insert([
            'status' => 'Placed orders',
            'order_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('order_statuses')->insert([
            'status' => 'Placed orders',
            'order_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
