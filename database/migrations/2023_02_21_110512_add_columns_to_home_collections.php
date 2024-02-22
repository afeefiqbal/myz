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
        Schema::table('home_collections', function (Blueprint $table) {
            $table->string('title1')->nullable();
            $table->string('title2')->nullable();
            $table->string('title3')->nullable();
            $table->string('title4')->nullable();
            $table->string('title5')->nullable();
            $table->string('title6')->nullable();
            $table->string('short_url1')->nullable();
            $table->string('short_url2')->nullable();
            $table->string('short_url6')->nullable();
            $table->string('short_url3')->nullable();
            $table->string('short_url4')->nullable();
            $table->string('short_url5')->nullable();
            $table->string('description1')->nullable();
            $table->string('description2')->nullable();
            $table->string('description3')->nullable();
            $table->string('description4')->nullable();
            $table->string('description5')->nullable();
            $table->string('description6')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_collections', function (Blueprint $table) {
            


         $table->dropColumn('title1');
        $table->dropColumn('title2');
        $table->dropColumn('title3');
        $table->dropColumn('title4');
        $table->dropColumn('title5');
        $table->dropColumn('title6');
        $table->dropColumn('short_url1');
        $table->dropColumn('short_url2');
        $table->dropColumn('short_url3');
        $table->dropColumn('short_url4');
        $table->dropColumn('short_url5');
        $table->dropColumn('short_url6');
        $table->dropColumn('description1');
        $table->dropColumn('description2');
        $table->dropColumn('description3');
        $table->dropColumn('description4');
        $table->dropColumn('description5');
        $table->dropColumn('description6');
        });
    }
};
