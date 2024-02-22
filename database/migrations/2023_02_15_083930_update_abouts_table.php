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
        Schema::table('abouts', function (Blueprint $table) {
            $table->text('banner_image')->after('image_attribute');
            $table->text('banner_image_webp')->after('banner_image');
            $table->string('banner_image_attribute')->after('banner_image_webp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('abouts', function (Blueprint $table) {
            $table->dropColumn('banner_image');
            $table->dropColumn('banner_image_webp');
            $table->dropColumn('banner_image_attribute');
        });
    }
};
