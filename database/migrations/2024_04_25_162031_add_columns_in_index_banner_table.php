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
            $table->longText('deal_image')->nullable();
            $table->string('deal_image_attribute')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('index_banner', function (Blueprint $table) {
            //
        });
    }
};
