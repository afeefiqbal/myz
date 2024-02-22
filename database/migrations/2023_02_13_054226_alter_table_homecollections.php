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

        Schema::table('homecollections', function (Blueprint $table) {
        $table->string('image_attribute')->nullable()->default(null);
        $table->string('image_attribute2')->nullable()->default(null);
        $table->string('image_attribute3')->nullable()->default(null);
        $table->string('image_attribute4')->nullable()->default(null);
        $table->string('image_attribute5')->nullable()->default(null);
        $table->string('image_attribute6')->nullable()->default(null);
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('homecollections', function (Blueprint $table) {
        $table->dropColumn('image_attribute');
        $table->dropColumn('image_attribute2');
        $table->dropColumn('image_attribute3');
        $table->dropColumn('image_attribute4');
        $table->dropColumn('image_attribute5');
        $table->dropColumn('image_attribute6');
    });
    }
};
