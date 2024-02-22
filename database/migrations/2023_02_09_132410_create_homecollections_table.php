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
        Schema::create('homecollections', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->longText('mobile_image_webp')->nullable();
            $table->longText('mobile_image')->nullable();
            $table->longText('mobile_image_webp1')->nullable();
            $table->longText('mobile_image1')->nullable();
            $table->longText('mobile_image_webp2')->nullable();
            $table->longText('mobile_image2')->nullable();
            $table->longText('mobile_image_webp3')->nullable();
            $table->longText('mobile_image3')->nullable();
            $table->longText('mobile_image_webp4')->nullable();
            $table->longText('mobile_image4')->nullable();
            $table->longText('mobile_image_webp5')->nullable();
            $table->longText('mobile_image5')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('homecollections');
    }
};
