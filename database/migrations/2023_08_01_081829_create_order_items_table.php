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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders');
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('color_id')->nullable()->constrained('product_colors') ;
            $table->foreignId('guarantee_id')->nullable()->constrained('guarantees') ;
            $table->integer('number')->default(1);
            $table->decimal('final_product_price_without_amazing_sale',20, 3)->nullable();
            $table->decimal('final_total_price_without_amazing_sale',20, 3)->nullable()->comment('number * final_product_price');
            $table->decimal('final_product_price_with_amazing_sale',20, 3)->nullable();
            $table->decimal('final_total_price_with_amazing_sale',20, 3)->nullable()->comment('number * final_product_price');
            $table->foreignId('amazing_sale_id')->constrained('amazing_sales');
            $table->foreignId('amazing_copan_id')->constrained('copans');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
