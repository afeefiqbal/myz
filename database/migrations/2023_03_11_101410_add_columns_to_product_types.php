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
        Schema::table('product_types', function (Blueprint $table) {
            $table->string('alternate_image')->nullable()->after('image_attribute');
            $table->string('alternate_image_webp')->nullable()->after('alternate_image');
            $table->string('alternate_image_attribute')->nullable()->after('alternate_image_webp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_types', function (Blueprint $table) {
            $table->dropColumn('alternate_image');
            $table->dropColumn('alternate_image_webp');
            $table->dropColumn('alternate_image_attribute');
        });
    }
};
