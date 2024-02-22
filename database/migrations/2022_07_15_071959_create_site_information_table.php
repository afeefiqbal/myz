<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_information', function (Blueprint $table) {
            $table->id();

            $table->string('contact_page_title')->nullable();
            $table->string('contact_request_title')->nullable();

            $table->string('brand_name')->nullable();
            $table->string('logo')->nullable();
            $table->string('logo_webp')->nullable();
            $table->string('logo_attribute')->nullable();

            $table->string('phone')->nullable();
            $table->string('alternate_phone')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('payment_query')->nullable();
            $table->text('address')->nullable();
            $table->text('google_map')->nullable();
            $table->string('email')->nullable();
            $table->string('alternate_email')->nullable();
            $table->string('email_recipient')->nullable();
            $table->text('working_hours')->nullable();

            $table->string('follow_title')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('snapchat_url')->nullable();
            $table->string('pinterest_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('twitter_url')->nullable();

            //policies
            $table->longText('google_review')->nullable();
            $table->text('copyright')->nullable();
            $table->longText('privacy_policy')->nullable();
            $table->longText('terms_and_conditions')->nullable();
            $table->longText('shipping_policy')->nullable();
            $table->longText('disclaimer')->nullable();
            $table->longText('return_policy')->nullable();

            //cart related
            $table->integer('tax')->default(5);
            $table->enum('tax_type', ['Inside', 'Outside'])->default('Inside');
            $table->integer('return_days')->default(7);
            $table->decimal('default_shipping_charge', 9, 2)->default(0);
            $table->decimal('cod_extra_charge', 9, 2)->default(0);

            // seo related
            $table->longText('header_tag')->nullable();
            $table->longText('footer_tag')->nullable();
            $table->longText('body_tag')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_information');
    }
}
