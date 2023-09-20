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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title',255);
            $table->text('description');
            $table->foreignId('author_id')->constrained('users');
            $table->text('image');
            $table->integer('count_viewer');
            $table->tinyInteger('selected_content')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->foreignId('product_category_id')->constrained('product_categories');
            $table->foreignId('article_category_id')->constrained('article_categories');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
