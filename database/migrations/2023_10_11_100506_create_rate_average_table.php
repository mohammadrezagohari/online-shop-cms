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
        Schema::create('rate_average', function (Blueprint $table) {
            $table->id();
            $table->foreignId("product_id")->constrained("products");
            $table->foreignId("product_category_question_id")->constrained("product_category_question");
            $table->integer("average_rate");
            $table->integer("insert_rate_count");
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
        Schema::dropIfExists('rate_average');
    }
};
