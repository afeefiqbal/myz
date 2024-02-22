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
            $table->string('phone_image')->nullable()->change();
            $table->string('address_image')->nullable()->change();
            $table->string('email_image')->nullable()->change();
            $table->text('phone_image_webp')->nullable()->change();
            $table->string('phone_image_attribute')->nullable()->change();
            $table->text('address_image_webp')->nullable()->change();
            $table->string('address_image_attribute')->nullable()->change();
            $table->text('email_image_webp')->nullable()->change();
            $table->string('email_image_attribute')->nullable()->change();
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
            $table->string('phone_image')->nullable(false)->change();
            $table->string('address_image')->nullable(false)->change();
            $table->string('email_image')->nullable(false)->change();
            $table->text('phone_image_webp')->nullable(false)->change();
            $table->string('phone_image_attribute')->nullable(false)->change();
            $table->text('address_image_webp')->nullable(false)->change();
            $table->string('address_image_attribute')->nullable(false)->change();
            $table->text('email_image_webp')->nullable(false)->change();
            $table->string('email_image_attribute')->nullable(false)->change();
        });
    }
};
