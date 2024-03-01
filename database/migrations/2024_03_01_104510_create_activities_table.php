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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('method');
            $table->string('url')->nullable();
            $table->string('response')->nullable();
            $table->string('refer')->nullable();
            $table->string('ip');
            
            $table->TEXT('gets')->nullable();
            $table->TEXT('posts')->nullable();
            $table->TEXT('cookies')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
