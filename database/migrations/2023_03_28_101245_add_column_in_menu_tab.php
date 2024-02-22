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
        Schema::table('menus', function (Blueprint $table) {
           $table->text('image')->nullable()->after('url');
           $table->text('image_webp')->nullable()->after('image');
           $table->text('image_attribute')->nullable()->after('image_webp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_tab', function (Blueprint $table) {
            //
        });
    }
};
