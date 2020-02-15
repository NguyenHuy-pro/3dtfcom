<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfAdsBannerImagesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tf_ads_banner_images', function (Blueprint $table) {
            $table->increments('image_id');
            $table->string('name', 20)->unique();
            $table->string('image', 255);
            $table->string('website', 255);
            $table->tinyInteger('confirm')->default(1);
            $table->tinyInteger('publish')->default(1);
            $table->dateTime('dateConfirm');
            $table->tinyInteger('action')->default(1);
            $table->dateTime('created_at');
            $table->integer('license_id')->unsigned();
            $table->foreign('license_id')->references('banner_id')->on('tf_ads_banner_licenses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tf_ads_banner_images');
    }

}
