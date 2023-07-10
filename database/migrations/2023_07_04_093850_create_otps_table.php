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
        Schema::create('otps', function (Blueprint $table) {
            $table->id();
            $table->string('token')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->string('otp_code');
            $table->string('login_id')->default(0)->comment('0=> mobile number, 1=>email address');
            $table->tinyInteger('type')->default(0)->comment('0 => mobile number , 1 => email');
            $table->tinyInteger('used')->default(0)->comment('0 => not used , 1 => used');
            $table->timestamp('expire_at')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
};
