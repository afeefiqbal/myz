<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->integer('parent_id')->nullable();
            $table->string('title');
            $table->string('short_url');
            $table->string('icon')->nullable();
            $table->string('icon_webp')->nullable();
            $table->string('image')->nullable();
            $table->string('image_webp')->nullable();
            $table->string('image_attribute')->nullable();
            $table->string('banner_title')->nullable();
            $table->string('banner_sub_title')->nullable();
            $table->longText('desktop_banner')->nullable();
            $table->longText('desktop_banner_webp')->nullable();
            $table->longText('mobile_banner')->nullable();
            $table->longText('mobile_banner_webp')->nullable();
            $table->string('banner_attribute')->nullable();
            $table->enum('display_to_home', ['Yes', 'No'])->default('No');
            $table->longText('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->longText('meta_keyword')->nullable();
            $table->longText('other_meta_tag')->nullable();
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
        Schema::dropIfExists('categories');
    }
}
