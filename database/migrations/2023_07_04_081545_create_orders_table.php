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
            $table->foreignId('user_id')->constrained('users') ;
            $table->foreignId('address_id')->nullable()->constrained('addresses') ;
            $table->foreignId('payment_id')->nullable()->constrained('payments') ;
            $table->tinyInteger('payment_type')->default(0);
            $table->tinyInteger('payment_status')->default(0);
            $table->foreignId('delivery_id')->nullable()->constrained('delivery') ;
            $table->decimal('delivery_amount',20, 3)->nullable();
            $table->tinyInteger('delivery_status')->default(0);
            $table->timestamp('delivery_date')->nullable();
            $table->decimal('order_final_amount',20, 3)->nullable();
            $table->decimal('order_final_amount_with_copan_discount',20, 3)->nullable();
            $table->foreignId('copan_id')->nullable()->constrained('copans') ;
            $table->tinyInteger('order_status')->default(0);
            $table->timestamps();
            $table->softDeletes();
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
