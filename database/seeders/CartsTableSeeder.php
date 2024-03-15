<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('carts')->insert([
            'customer_id' => 3,
            'product_id' => 1,
            'quantity' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('carts')->insert([
            'customer_id' => 3,
            'product_id' => 2,
            'quantity' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
