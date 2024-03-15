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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number');
            $table->string('invoice_number');
            $table->string('payment_method');
            $table->string('fullname');
            $table->string('email');
            $table->string('address');
            $table->string('products_ordered');
            $table->decimal('total_amount', 10, 2);
            $table->string('status');
            $table->timestamp('ordered_date')->nullable();
            $table->timestamp('receiving_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
