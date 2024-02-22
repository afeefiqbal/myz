<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductKeyFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_key_features', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('title')->nullable();
            $table->string('video_url')->nullable();
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->text('image_webp')->nullable();
            $table->string('image_attribute')->nullable();
            $table->integer('sort_order')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
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
        Schema::dropIfExists('product_key_features');
    }
}
