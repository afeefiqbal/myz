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
        Schema::rename('homecollections', 'home_collections');
        Schema::table('home_collections', function (Blueprint $table) {
           $table->string('sub_title')->nullable();
           $table->text('url1')->nullable();
            $table->text('url2')->nullable();
            $table->text('url3')->nullable();
            $table->text('url4')->nullable();
            $table->text('url5')->nullable();
            $table->text('url6')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_collection', function (Blueprint $table) {
            //
        });
    }
};
