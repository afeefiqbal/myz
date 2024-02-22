<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('short_url');
            $table->longtext('description')->nullable();
            $table->string('sub_title')->nullable();
            $table->longtext('alternate_description')->nullable();
            $table->string('image')->nullable();
            $table->string('image_webp')->nullable();
            $table->string('image_attribute')->nullable();
            $table->string('author')->nullable();
            $table->string('author_image')->nullable();
            $table->string('author_image_webp')->nullable();
            $table->date('posted_date')->nullable();

            $table->string('video_url')->nullable();
            $table->string('video_thumbnail_image')->nullable();
            $table->string('video_thumbnail_image_webp')->nullable();
            $table->string('video_thumbnail_image_attribute')->nullable();

            $table->string('banner_title')->nullable();
            $table->string('banner_sub_title')->nullable();
            $table->longText('desktop_banner')->nullable();
            $table->longText('desktop_banner_webp')->nullable();
            $table->longText('mobile_banner')->nullable();
            $table->longText('mobile_banner_webp')->nullable();
            $table->longText('banner_attribute')->nullable();

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
        Schema::dropIfExists('blogs');
    }
}
