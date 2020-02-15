<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBannerExchangesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_banner_exchanges', function(Blueprint $table)
		{
			$table->increments('exchange_id');
			$table->integer('exchangePoint')->default(0);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdded');
			$table->integer('transactionStatus_id')->unsigned();
			$table->foreign('transactionStatus_id')->references('status_id')->on('tf_transaction_statuses')->onDelete('cascade');
			$table->integer('banner_id')->unsigned();
			$table->foreign('banner_id')->references('banner_id')->on('tf_banners')->onDelete('cascade');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('user_id')->on('tf_users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_banner_exchanges');
	}

}
