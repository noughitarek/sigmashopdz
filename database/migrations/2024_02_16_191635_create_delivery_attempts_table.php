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
        Schema::create('delivery_attempts', function (Blueprint $table) {
            $table->id();
            $table->string("response")->nullable();
            
            $table->unsignedBigInteger('order');
            $table->foreign('order')->references('id')->on('orders');

            $table->string('delivery_man')->nullable();
            $table->string('station')->nullable();

            $table->unsignedBigInteger('attempt_by')->nullable();
            $table->foreign('attempt_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_attempts');
    }
};
