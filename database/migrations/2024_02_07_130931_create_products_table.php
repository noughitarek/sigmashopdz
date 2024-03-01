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
            
            $table->string('name');
            $table->string('slug')->unique();

            $table->double('price');
            $table->double('old_price')->nullable();

            $table->string('photos')->nullable();
            $table->string('videos')->nullable();

            $table->boolean('is_active')->default(true);
            $table->longText('description')->nullable();

            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('category');

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('category')->references('id')->on('categories');

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
