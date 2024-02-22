<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_customers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id');
            $table->enum('user_type', ['Guest', 'User']);
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('billing_address');
            $table->unsignedBigInteger('shipping_address');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_customers');
    }
}
