<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfConvertPointsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_convert_points', function(Blueprint $table)
		{
			$table->increments('convert_id');
			$table->integer('point');
			$table->integer('convertValue');
			$table->tinyInteger('action')->default(1);
			$table->integer('type_id')->unsigned();
			$table->foreign('type_id')->references('type_id')->on('tf_convert_types')->onDelete('cascade');
			$table->integer('staff_id')->unsigned();
			$table->foreign('staff_id')->references('staff_id')->on('tf_staffs')->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_convert_points');
	}

}
