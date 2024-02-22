<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('code');
            $table->enum('type', ['Fixed', 'Percentage'])->default('Fixed');
            $table->float('coupon_value');
            $table->enum('is_free_shipping', ['Yes', 'No'])->default('No');
            $table->date('expiry_date');
            $table->float('minimum_spend')->default(0.00);
            $table->float('maximum_spend')->default(0.00);
            $table->float('coupon_value_limit')->nullable();
            $table->enum('individual_use', ['Yes', 'No'])->default('Yes');
            $table->longText('included_categories')->nullable();
            $table->longText('excluded_categories')->nullable();
            $table->longText('included_products')->nullable();
            $table->longText('excluded_products')->nullable();
            $table->longText('allowed_mails')->nullable();
            $table->integer('usage_per_coupon');
            $table->integer('usage_per_person')->default(1);
            $table->enum('applicable_only_if_sale_price', ['Yes', 'No'])->default('Yes');
            $table->enum('allow_public', ['Yes', 'No'])->default('Yes');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');

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
        Schema::dropIfExists('coupons');
    }
}
