<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products_size_price', function (Blueprint $table) {
            //
            $table->enum('availability', ['In Stock', 'Out of Stock'])->default('In Stock');
            $table->float('stock')->nullable();
            $table->float('alert_quantity')->nullable();
            $table->string('quantity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_size_price', function (Blueprint $table) {
            //
        });
    }
};
