<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfConvertTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_convert_types', function(Blueprint $table)
		{
			$table->increments('type_id');
			$table->string('name',50)->unique();
			$table->string('description',200);
			$table->tinyInteger('action')->default(1);
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
		Schema::drop('tf_convert_types');
	}

}
