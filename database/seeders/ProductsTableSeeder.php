<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            'product_code' => 'B001',
            'product_picture' => 'https://sunnywoodrice.com/wp-content/uploads/2019/03/Harvesters-Dinorado-2018-2kg.jpg',
            'product_name' => 'Dinorado',
            'product_price' => '200.23',
            'product_type' => 'Glotinous',
            'product_net_wt' => '2kg',
            'product_grain' => 'Long grain',
            'product_stocks' => 25,
            'product_status' => 'Available',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('products')->insert([
            'product_code' => 'B002',
            'product_picture' => 'https://sunnywoodrice.com/wp-content/uploads/2019/03/Harvesters-Dinorado-2018-2kg.jpg',
            'product_name' => 'Jasmine',
            'product_price' => '400.23',
            'product_type' => 'Glotinous',
            'product_net_wt' => '2kg',
            'product_grain' => 'Long grain',
            'product_stocks' => 25,
            'product_status' => 'Available',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
