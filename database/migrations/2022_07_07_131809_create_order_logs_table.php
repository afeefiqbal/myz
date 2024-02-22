<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_logs', function (Blueprint $table) {
            $table->id();

            $table->string('order_product_id');
            $table->enum('status', ['Pending', 'Processing', 'On Hold', 'Cancelled', 'Packed', 'Shipped', 'Out for Delivery', 'Delivered', 'Completed', 'Returned', 'Refunded', 'Failed'])->default('Pending');
            $table->enum('refund_type', ['None', 'Credit Point', 'Voucher', 'Bank Account'])->default('None');
            $table->string('account_holder_name')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('account_number')->nullable();
            $table->longText('remarks')->nullable();

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
        Schema::dropIfExists('order_logs');
    }
}
