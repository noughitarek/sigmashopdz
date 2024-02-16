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
        Schema::create('confirmation_attempts', function (Blueprint $table) {
            $table->id();
            $table->string("response")->nullable();
            $table->string("state")->default("not confirmed");
            
            $table->unsignedBigInteger('order');
            $table->foreign('order')->references('id')->on('orders');

            $table->unsignedBigInteger('attempt_by');
            $table->foreign('attempt_by')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('confirmation_attempts');
    }
};
