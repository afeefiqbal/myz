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
        Schema::dropIfExists('banners');
        Schema::create('banners', function (Blueprint $table) {
           $table->text('product_banner')->nullable();
           $table->text('product_banner_text')->nullable();
           $table->text('product_banner_url')->nullable();
           $table->text('about_first_bottom_image')->nullable();
           $table->text('about_first_bottom_image_text')->nullable();
           $table->text('about_second_bottom_image')->nullable();
           $table->text('about_second_bottom_image_text')->nullable();
           $table->text('about_third_bottom_image')->nullable();
           $table->text('about_third_bottom_image_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('banners_', function (Blueprint $table) {
            //
        });
    }
};
