<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfLandReservesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_land_reserves', function(Blueprint $table)
		{
			$table->increments('reserve_id');
			$table->tinyInteger('receive')->default(0);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdded');
			$table->integer('land_id')->unsigned();
			$table->foreign('land_id')->references('land_id')->on('tf_lands')->onDelete('cascade');
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
		Schema::drop('tf_land_reserves');
	}

}
