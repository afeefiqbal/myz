<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('short_url');
            $table->longText('image')->nullable();
            $table->longText('webp_image')->nullable();
            $table->string('image_meta_tag')->nullable();
            $table->string('banner_title')->nullable();
            $table->string('banner_sub_title')->nullable();
            $table->longText('desktop_banner')->nullable();
            $table->longText('desktop_banner_webp')->nullable();
            $table->longText('mobile_banner')->nullable();
            $table->longText('mobile_banner_webp')->nullable();
            $table->string('banner_attribute')->nullable();
            $table->enum('display_to_home', ['Yes', 'No'])->default('No');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('other_meta_tag')->nullable();

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
        Schema::dropIfExists('brands');
    }
}
