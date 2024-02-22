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

            $table->string('order_code');
            $table->enum('payment_method', ['COD', 'Payment-Gateway', 'Credit-Card', 'Debit-Card', 'UPI']);
            $table->longText('remarks')->nullable();
            $table->integer('tax');
            $table->enum('tax_type', ['Inside', 'Outside'])->default('Inside');
            $table->decimal('tax_amount', 9, 2);
            $table->decimal('shipping_charge', 9, 2);
            $table->string('currency');
            $table->decimal('currency_charge', 9, 2);
            $table->decimal('cod_extra_charge', 9, 2);

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
        Schema::dropIfExists('orders');
    }
}
