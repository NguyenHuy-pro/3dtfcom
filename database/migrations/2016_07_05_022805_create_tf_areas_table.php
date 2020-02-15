<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfAreasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_areas', function(Blueprint $table)
		{
			$table->increments('area_id');
			$table->integer('width')->default(896);
			$table->integer('height')->default(896);
			$table->integer('leftPosition')->default(0);
			$table->integer('topPosition')->default(0);
			$table->integer('x')->default(0);
			$table->integer('y')->default(0);
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
		Schema::drop('tf_areas');
	}

}
