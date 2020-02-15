<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfUserExchangeBuildingSamplesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_user_exchange_building_samples', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('user_id')->on('tf_users')->onDelete('cascade');
			$table->integer('sample_id')->unsigned();
			$table->foreign('sample_id')->references('sample_id')->on('tf_building_samples')->onDelete('cascade');
			$table->integer('exchangePoint');
			$table->dateTime('dateAdded');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_user_exchange_building_samples');
	}

}
