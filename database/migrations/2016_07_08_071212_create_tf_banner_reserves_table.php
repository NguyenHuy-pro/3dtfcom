<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBannerReservesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_banner_reserves', function(Blueprint $table)
		{
			$table->increments('reserve_id');
			$table->tinyInteger('receive')->default(0);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdded');
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
		Schema::drop('tf_banner_reserves');
	}

}
