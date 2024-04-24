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
        Schema::create('index_banner', function (Blueprint $table) {
            $table->id();
            $table->longText('main_banner')->nullable();
            $table->string('main_banner_attribute')->nullable();
            $table->longText('left_side_banner')->nullable();
            $table->string('left_banner_attribute')->nullable();
            $table->longText('left_second_banner')->nullable();
            $table->string('left_second_banner_attribute')->nullable();
            $table->longText('bottom_first_image')->nullable();
            $table->string('bottom_first_image_attribute')->nullable();
            $table->longText('bottom_second_image')->nullable();
            $table->string('bottom_second_image_attribute')->nullable();
            $table->longText('bottom_third_image')->nullable();
            $table->string('bottom_third_image_attribute')->nullable();
            $table->longText('bottom_fourth_image')->nullable();
            $table->string('bottom_fourth_image_attribute')->nullable();
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
        Schema::dropIfExists('index_banner');
    }
};
