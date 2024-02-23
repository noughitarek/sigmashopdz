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
        Schema::create('payements', function (Blueprint $table) {
            $table->id();
            $table->double("amount")->default(0);

            $table->unsignedBigInteger('payed_by');
            $table->foreign('payed_by')->references('id')->on('users');

            $table->unsignedBigInteger('payed_to')->nullable();
            $table->foreign('payed_to')->references('id')->on('users');
            
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payements');
    }
};
