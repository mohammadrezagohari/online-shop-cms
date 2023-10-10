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
        Schema::create('join_us', function (Blueprint $table) {
            $table->id();
            $table->string("first_name", 255);
            $table->string("last_name", 255);
            $table->string("email", 255);
            $table->string("company_name", 255);
            $table->string("referral_code", 255)->nullable();
            $table->string("mobile", 11);
            $table->text("brands");
            $table->tinyInteger("brand_registration")->default("0");
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
        Schema::dropIfExists('join_us');
    }
};
