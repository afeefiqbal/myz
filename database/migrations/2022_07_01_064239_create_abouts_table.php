<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->longText('description')->nullable();
            $table->text('image')->nullable();
            $table->text('image_webp')->nullable();
            $table->string('image_attribute')->nullable();
            $table->string('video_url')->nullable();
            $table->string('feature_title')->nullable();
            $table->longText('feature_description')->nullable();
            $table->text('feature_image')->nullable();
            $table->text('feature_image_webp')->nullable();
            $table->text('feature_image_attribute')->nullable();
            $table->string('history_title')->nullable();
            $table->longText('history_description')->nullable();
            $table->string('products_available_title')->nullable();
            $table->longText('products_available_description')->nullable();
            $table->text('products_available_image')->nullable();
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
        Schema::dropIfExists('abouts');
    }
}
