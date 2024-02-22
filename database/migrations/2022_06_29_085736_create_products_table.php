<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->longText('short_url');
            $table->string('sku');
            $table->longText('category_id');
            $table->longText('sub_category_id')->nullable();
            $table->longText('description')->nullable();
            $table->string('capacity')->nullable();
            $table->integer('color_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->integer('measurement_unit_id')->nullable();
            $table->enum('availability', ['In Stock', 'Out of Stock'])->default('In Stock');
            $table->float('stock')->nullable();
            $table->float('alert_quantity')->nullable();
            $table->string('quantity')->nullable();
            $table->decimal('price', 9, 2);
            $table->longText('thumbnail_image')->nullable();
            $table->longText('thumbnail_image_webp')->nullable();
            $table->longText('thumbnail_image_attribute')->nullable();
            $table->string('banner_title')->nullable();
            $table->string('banner_sub_title')->nullable();
            $table->longText('desktop_banner')->nullable();
            $table->longText('desktop_banner_webp')->nullable();
            $table->longText('mobile_banner')->nullable();
            $table->longText('mobile_banner_webp')->nullable();
            $table->string('banner_attribute')->nullable();
            $table->string('warranty')->default(0);
            $table->longText('tag_id')->nullable();
            $table->longText('add_on_id')->nullable();
            $table->longText('similar_product_id')->nullable();
            $table->longText('related_product_id')->nullable();
            $table->longText('product_manual')->nullable();
            $table->longText('featured_image')->nullable();
            $table->longText('featured_image_webp')->nullable();
            $table->string('featured_image_attribute')->nullable();
            $table->string('featured_video_url')->nullable();
            $table->text('featured_description')->nullable();
            $table->enum('display_to_home', ['Yes', 'No'])->default('No');
            $table->enum('new_arrival', ['Yes', 'No'])->default('Yes');
            $table->enum('is_featured', ['Yes', 'No'])->default('No');
            $table->enum('best_seller', ['Yes', 'No'])->default('No');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->longText('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->longText('meta_keyword')->nullable();
            $table->longText('other_meta_tag')->nullable();

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
        Schema::dropIfExists('products');
    }
}
