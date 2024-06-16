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
        Schema::table('home_banners', function (Blueprint $table) {
            $table->longText('side_first_banner')->nullable();
            $table->string('side_first_banner_attribute')->nullable();
            $table->string('side_first_banner_url')->nullable();
            $table->longText('side_second_banner')->nullable();
            $table->string('side_second_banner_attribute')->nullable();
            $table->string('side_second_banner_url')->nullable();
            $table->longText('category_first_banner')->nullable();
            $table->string('category_first_banner_attribute')->nullable();
            $table->string('category_first_banner_url')->nullable();
            $table->longText('category_second_banner')->nullable();
            $table->string('category_second_banner_attribute')->nullable();
            $table->string('category_second_banner_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_banners', function (Blueprint $table) {
            //
        });
    }
};
