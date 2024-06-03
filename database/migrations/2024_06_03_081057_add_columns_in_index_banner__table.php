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
        Schema::table('index_banner', function (Blueprint $table) {
            $table->string('main_banner_url')->nullable();
            $table->string('left_side_banner_url')->nullable();
            $table->string('left_second_banner_url')->nullable();
            $table->string('bottom_first_image_url')->nullable();
            $table->string('bottom_second_image_url')->nullable();
            $table->string('bottom_third_image_url')->nullable();
            $table->string('bottom_fourth_image_url')->nullable();
            $table->string('deal_image_url')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('index_banner_', function (Blueprint $table) {
            //
        });
    }
};
