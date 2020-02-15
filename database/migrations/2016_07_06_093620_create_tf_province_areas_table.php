<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfProvinceAreasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_province_areas', function(Blueprint $table)
		{
			$table->integer('province_id')->unsigned();
			$table->foreign('province_id')->references('province_id')->on('tf_provinces')->onDelete('cascade');
			$table->integer('area_id')->unsigned();
			$table->foreign('area_id')->references('area_id')->on('tf_areas')->onDelete('cascade');
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
		Schema::drop('tf_province_areas');
	}

}
