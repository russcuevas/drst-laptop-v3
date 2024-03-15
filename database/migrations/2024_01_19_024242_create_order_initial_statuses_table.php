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
        Schema::create('order_initial_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('initial_status');
            $table->unsignedBigInteger('status_id');
            $table->timestamp('placed_at')->nullable();
            $table->timestamp('on_process_at')->nullable();
            $table->timestamp('on_the_way_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
            $table->foreign('status_id')->references('id')->on('order_statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_initial_statuses');
    }
};
