<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('slug',120)->unique();
            $table->string('title',120);
            $table->string('main_image');
            $table->longText('content');
            $table->string('seo_keywords')->nullable();
            $table->string('seo_description')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->string('status')->default('new');
            $table->foreignId('category_id')->nullable()->constrained('categories')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
