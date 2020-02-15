<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfLandLicensesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_land_licenses', function(Blueprint $table)
		{
			$table->increments('license_id');
			$table->string('name',20)->unique();
			$table->dateTime('dateBegin');
			$table->dateTime('dateEnd');
			$table->tinyInteger('status')->default(1);
			$table->tinyInteger('action')->default(1);
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
		Schema::drop('tf_land_licenses');
	}

}
