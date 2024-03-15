<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_details')->insert([
            'customer_id' => 3,
            'product_id' => 1,
            'fullname' => "Customers",
            'contact' => '09495748302',
            'email' => 'jc@gmail.com',
            'address' => '#83, Barangay Tambo Lipa City Batangas',
            'subtotal' => 200.23,
            'products_ordered' => 'Dinorado (200.23)',
            'total_amount' => 423.67,
            'total_quantity' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('order_details')->insert([
            'customer_id' => 3,
            'product_id' => 2,
            'fullname' => "Customers",
            'contact' => '09495748302',
            'email' => 'jc@gmail.com',
            'address' => '#83, Barangay Tambo Lipa City Batangas',
            'subtotal' => 23.21,
            'products_ordered' => 'Sample 2 (23.21)',
            'total_amount' => 423.67,
            'total_quantity' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
