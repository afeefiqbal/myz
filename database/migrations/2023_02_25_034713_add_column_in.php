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
        Schema::table('side_menus', function (Blueprint $table) {
            $table->string('image')->nullable()->after('sort_order');
            $table->string('image_webp')->nullable()->after('image');
            $table->string('image_attribute')->nullable()->after('image_webp');
        });
        Schema::table('side_menu_details', function (Blueprint $table) {
            $table->string('sort_order')->nullable()->after('status');
            $table->string('image')->nullable()->after('sort_order');
            $table->string('image_webp')->nullable()->after('image');
            $table->string('image_attribute')->nullable()->after('image_webp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
