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
        Schema::table('products', function (Blueprint $table) {
            //drop column
            $table->dropColumn('capacity');   
            $table->dropColumn('color_id');
            $table->dropColumn('measurement_unit_id');
            $table->dropColumn('brand_id');
            $table->dropColumn('banner_title');
            $table->dropColumn('banner_sub_title');
            $table->dropColumn('mobile_banner');
            $table->dropColumn('mobile_banner_webp');
            $table->dropColumn('warranty');
            $table->dropColumn('add_on_id');
            $table->dropColumn('similar_product_id');
            $table->dropColumn('product_manual');
            $table->dropColumn('type');
            $table->dropColumn('latest');
            $table->dropColumn('product_type_id');
            $table->dropColumn('size_id');
            $table->dropColumn('shape_id');
         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
       
        });
    }
};
