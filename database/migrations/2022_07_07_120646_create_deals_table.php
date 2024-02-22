<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();

            $table->enum('product_list_type', ['Brand', 'Category', 'Sub-category'])->default('Brand');
            $table->string('type_value');
            $table->string('title');
            $table->string('short_url');
            $table->enum('offer_type', ['Bogo', 'Normal', 'Fixed', 'Percentage'])->default('Fixed');
            $table->bigInteger('offer_value');
            $table->enum('offer_option', ['Offer', 'No Offer', 'Both'])->default('Offer');
            $table->date('start_date');
            $table->date('end_date');
            $table->longText('products');
            $table->string('banner_title')->nullable();
            $table->string('banner_sub_title')->nullable();
            $table->longText('desktop_banner')->nullable();
            $table->longText('desktop_banner_webp')->nullable();
            $table->longText('mobile_banner')->nullable();
            $table->longText('mobile_banner_webp')->nullable();
            $table->string('banner_attribute')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->longText('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->longText('meta_keyword')->nullable();
            $table->longText('other_meta_tag')->nullable();

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
        Schema::dropIfExists('deals');
    }
}
