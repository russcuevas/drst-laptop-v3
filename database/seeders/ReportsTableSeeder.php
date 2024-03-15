<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reports')->insert([
            'reference_number' => 'REF01',
            'invoice_number' => 'INV01',
            'payment_method' => 'Cash on delivery',
            'fullname' => 'Customers',
            'email' => 'jc@gmail.com',
            'address' => '#83, Barangay Tambo Lipa City Batangas',
            'products_ordered' => 'Dinorado (200.23), Sample 2 (23.21)',
            'total_amount' => 423.67,
            'status' => 'Delivered',
            'ordered_date' => now(),
            'receiving_date' => now()
        ]);
    }
}
