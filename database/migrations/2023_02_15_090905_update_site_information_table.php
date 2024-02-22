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
        Schema::table('site_information', function (Blueprint $table) {
            $table->text('phone_image_webp')->after('phone_image');
            $table->string('phone_image_attribute')->after('phone_image_webp');
            $table->text('address_image_webp')->after('address_image');
            $table->string('address_image_attribute')->after('address_image_webp');
            $table->text('email_image_webp')->after('email_image');
            $table->string('email_image_attribute')->after('email_image_webp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_information', function (Blueprint $table) {
            $table->dropColumn('phone_image_webp');
            $table->dropColumn('phone_image_attribute');
            $table->dropColumn('address_image_webp');
            $table->dropColumn('address_image_attribute');
            $table->dropColumn('email_image_webp');
            $table->dropColumn('email_image_attribute');



        });
    }
};
