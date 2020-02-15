<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfAdsBannerExchangesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_ads_banner_exchanges', function(Blueprint $table)
		{
			$table->increments('exchange_id');
			$table->integer('point');
			$table->integer('license_id')->unsigned();
			$table->foreign('license_id')->references('license_id')->on('tf_ads_banner_licenses')->onDelete('cascade');
			$table->integer('card_id')->unsigned();
			$table->foreign('card_id')->references('card_id')->on('tf_user_cards')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_ads_banner_exchanges');
	}

}
