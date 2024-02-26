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
            $table->unsignedBigInteger('commune');
            $table->foreign('commune')->references('id')->on('communes');
            $table->unsignedBigInteger('wilaya');
            $table->foreign('wilaya')->references('id')->on('wilayas');
            $table->integer('quantity');
            $table->double('total_price');
            $table->double('delivery_price');
            $table->double('clean_price');
            $table->string('intern_tracking')->unique();
            $table->string('tracking')->nullable();
            $table->string('ip');
            $table->boolean('stopdesk')->default(false);
            $table->timestamp('confirmed_at')->nullable();
            $table->unsignedBigInteger('confirmed_by')->nullable();
            $table->foreign('confirmed_by')->references('id')->on('users');

            $table->timestamp('shipped_at')->nullable();
            $table->unsignedBigInteger('shipped_by')->nullable();
            $table->foreign('shipped_by')->references('id')->on('users');

            $table->timestamp('validated_at')->nullable();
            $table->unsignedBigInteger('validated_by')->nullable();
            $table->foreign('validated_by')->references('id')->on('users');

            $table->timestamp('delivery_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('ready_at')->nullable();

            $table->timestamp('recovered_at')->nullable();
            $table->unsignedBigInteger('recovered_by')->nullable();
            $table->foreign('recovered_by')->references('id')->on('users');
            
            $table->timestamp('back_at')->nullable();
            $table->timestamp('back_ready_at')->nullable();
            
            $table->timestamp('failure_at')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->unsignedBigInteger('archived_by')->nullable();
            $table->foreign('archived_by')->references('id')->on('users');
            $table->timestamp('doubled_at')->nullable();

            $table->unsignedBigInteger('product')->nullable();
            $table->foreign('product')->references('id')->on('products');
            $table->unsignedBigInteger('campaign')->nullable();
            $table->foreign('campaign')->references('id')->on('campaigns');

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
