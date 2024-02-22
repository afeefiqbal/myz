<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('color')->nullable();
            $table->unsignedBigInteger('offer_id');
            $table->decimal('offer_amount', 9, 2);
            $table->boolean('is_bogo')->default(0);
            $table->decimal('cost', 9, 2);
            $table->integer('qty');
            $table->decimal('shipping_cost', 9, 2)->default('0.00');
            $table->decimal('total', 9, 2);
            $table->decimal('coupon_value', 9, 2);
            $table->decimal('coupon_after_price', 9, 2);

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
        Schema::dropIfExists('order_products');
    }
}
