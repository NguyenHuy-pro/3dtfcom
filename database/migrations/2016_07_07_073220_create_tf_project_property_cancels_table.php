<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfProjectPropertyCancelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_project_property_cancels', function(Blueprint $table)
		{
			$table->increments('cancel_id');
			$table->string('notifyContent',200);
			$table->string('reason',200);
			$table->tinyInteger('new')->default(1);
			$table->dateTime('dateAdded');
			$table->integer('projectProperty_id')->unsigned();
			$table->foreign('projectProperty_id')->references('property_id')->on('tf_project_properties')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_project_property_cancels');
	}

}
