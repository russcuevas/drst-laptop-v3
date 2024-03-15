<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            'reference_number' => 'REF01',
            'invoice_number' => 'INV01',
            'payment_method' => 'Cash on delivery',
            'order_details_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('orders')->insert([
            'reference_number' => 'REF01',
            'invoice_number' => 'INV01',
            'payment_method' => 'Cash on delivery',
            'order_details_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
