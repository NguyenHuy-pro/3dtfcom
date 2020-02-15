<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfCountriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_countries', function(Blueprint $table)
		{
			$table->increments('country_id');
			$table->string('name',30)->unique();
			$table->string('codeCountry',10)->unique();
			$table->string('flagImage',50)->nullable();
			$table->string('moneyUnit',30)->nullable();
			$table->tinyInteger('build3d')->default(0);
			$table->tinyInteger('centerDefault')->default(0);
			$table->tinyInteger('status')->default(1);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdd');
			$table->dateTime('dateBuild3d')->nullable();
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
		Schema::drop('tf_countries');
	}

}
