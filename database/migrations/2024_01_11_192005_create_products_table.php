<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code');
            $table->string('product_picture');
            $table->string('product_name');
            $table->string('product_price');
            $table->string('product_type');
            $table->string('product_net_wt');
            $table->string('product_grain');
            $table->integer('product_stocks');
            $table->string('product_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
