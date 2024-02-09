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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('phone2')->nullable();
            $table->string('address');
            $table->string('commune');
            $table->string('wilaya');
            $table->string('campaign')->nullable();
            $table->unsignedBigInteger('product');
            $table->integer('quantity');
            $table->double('total_price');
            $table->double('delivery_price');
            $table->double('clean_price');
            $table->string('tracking')->nullable();
            $table->string('ip');
            
            $table->text('confirmation_attempts')->nullable();

            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('validated_at')->nullable();
            $table->timestamp('delivery_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('ready_at')->nullable();
            $table->timestamp('recovered_at')->nullable();
            $table->timestamp('back_at')->nullable();
            $table->timestamp('back_ready_at')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->timestamp('doubled_at')->nullable();

            $table->unsignedBigInteger('confirmed_by')->nullable();
            $table->foreign('confirmed_by')->references('id')->on('users');
            $table->unsignedBigInteger('recovered_by')->nullable();
            $table->foreign('recovered_by')->references('id')->on('users');
            $table->foreign('product')->references('id')->on('products');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
