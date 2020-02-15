<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfAdsBannerLicensesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tf_ads_banner_licenses', function (Blueprint $table) {
            $table->increments('license_id');
            $table->string('name', 20)->unique();
            $table->dateTime('dateBegin');
            $table->dateTime('dateEnd');
            $table->tinyInteger('private')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('action')->default(1);
            $table->integer('banner_id')->unsigned();
            $table->dateTime('created_at');
            $table->foreign('banner_id')->references('banner_id')->on('tf_ads_banners')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('user_id')->on('tf_users')->onDelete('cascade');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tf_ads_banner_licenses');
    }

}
