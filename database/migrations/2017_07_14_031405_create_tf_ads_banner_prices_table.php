<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfAdsBannerPricesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tf_ads_banner_prices', function (Blueprint $table) {
            $table->increments('price_id');
            $table->integer('point');
            $table->integer('amountImage');
            $table->string('unit');
            $table->tinyInteger('action')->default(1);
            $table->dateTime('created_at');
            $table->integer('banner_id')->unsigned();
            $table->foreign('banner_id')->references('banner_id')->on('tf_ads_banners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tf_ads_banner_prices');
    }

}
