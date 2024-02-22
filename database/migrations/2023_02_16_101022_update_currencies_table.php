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
        Schema::table('currencies', function (Blueprint $table) {
            $table->string('image')->nullable()->after('symbol');
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
        Schema::table('currencies', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('image_webp');
            $table->dropColumn('image_attribute');
        });
    }
};
