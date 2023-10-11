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
        Schema::create('product_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId("product_category_question_id")->constrained("product_category_question");
            $table->tinyInteger("rate")->default("3");
            $table->foreignId("product_id")->constrained("products");
            $table->foreignId("user_id")->constrained("users")->nullable();
            $table->text("comment");
            $table->tinyInteger("status")->default("0");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_rates');
    }
};
