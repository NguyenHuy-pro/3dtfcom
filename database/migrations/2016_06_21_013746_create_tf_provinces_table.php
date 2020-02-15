<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfProvincesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_provinces', function(Blueprint $table)
		{
			$table->increments('province_id');
			$table->string('name',50)->unique();
			$table->tinyInteger('build3d')->default(0);
			$table->tinyInteger('defaultCenter')->default(0);
			$table->tinyInteger('status')->default(1);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdd');
			$table->integer('provinceType_id')->unsigned();
			$table->foreign('provinceType_id')->references('type_id')->on('tf_province_types')->onDelete('cascade');
			$table->integer('country_id')->unsigned();
			$table->foreign('country_id')->references('country_id')->on('tf_countries')->onDelete('cascade');
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
		Schema::drop('tf_provinces');
	}

}
