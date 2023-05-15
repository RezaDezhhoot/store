<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->index();
            $table->text('seo_keyword')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('title');
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->longText('details')->nullable();
            $table->longText('media')->nullable();
            $table->integer('quantity');
            $table->decimal('price',20);
            $table->string('discount_type');
            $table->unsignedMediumInteger('discount_amount');
            $table->date('start_at')->nullable();
            $table->date('expire_at')->nullable();
            $table->string('status');
            $table->string('image');
            $table->foreignId('category_id')->nullable()->constrained('categories')->cascadeOnDelete();
            $table->float('score')->default(2.5);
            $table->longText('form')->nullable();
            $table->integer('guarantee')->default(0);
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
        Schema::dropIfExists('products');
    }
}
