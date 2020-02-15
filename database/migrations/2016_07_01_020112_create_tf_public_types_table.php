<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfPublicTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_public_types', function(Blueprint $table)
		{
			$table->increments('type_id');
			$table->string('name',30)->unique();
			$table->tinyInteger('status')->default(1);
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
		Schema::drop('tf_public_types');
	}

}
