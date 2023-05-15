<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('send_id')->constrained('sends')->onDelete('cascade');
            $table->string('user_ip');
            $table->decimal('price',18,0);
            $table->decimal('total_price',18,0);
            $table->string('reduction_code')->nullable();
            $table->decimal('reductions_value',18,0)->nullable();
            $table->unsignedInteger('wallet_pay');
            $table->unsignedInteger('discount');
            $table->string('phone',11);
            $table->string('name');
            $table->string('province');
            $table->string('city');
            $table->string('address');
            $table->string('postal_code');
            $table->text('description')->nullable();
            $table->string('transactionId')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
