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
        Schema::create('help_size', function (Blueprint $table) {
            $table->id();
            $table->string("size",255);
            $table->string("height",255);
            $table->string("Waist",255);
            $table->string("sleeveـlength",255);
            $table->foreignId("product_id")->constrained("products");
            $table->tinyInteger("status")->default("1");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('help_size');
    }
};
