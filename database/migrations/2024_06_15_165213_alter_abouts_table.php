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
        Schema::table('abouts', function (Blueprint $table) {
            $table->text('first_div')->nullable()->change();
            $table->longText('first_div_image')->nullable();
            $table->text('first_div_count')->nullable();
            $table->text('second_div')->nullable()->change();
            $table->string('second_div_image')->nullable();
            $table->text('second_div_count')->nullable();
            $table->text('third_div')->nullable()->change();
            $table->text('third_div_image')->nullable();
            $table->text('third_div_count')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
