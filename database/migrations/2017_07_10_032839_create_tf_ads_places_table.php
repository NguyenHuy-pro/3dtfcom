<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfAdsPlacesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tf_ads_places', function (Blueprint $table) {
            $table->increments('place_id');
            $table->string('name', 30)->unique();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('action')->default(1);
            $table->dateTime('created_at');
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
        Schema::drop('tf_ads_places');
    }

}
