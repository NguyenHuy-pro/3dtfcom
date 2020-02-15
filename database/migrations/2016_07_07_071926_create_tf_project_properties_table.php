<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfProjectPropertiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_project_properties', function(Blueprint $table)
		{
			$table->increments('property_id');
			$table->dateTime('dateBegin');
			$table->dateTime('dateEnd');
			$table->tinyInteger('status')->default(1);
			$table->tinyInteger('action')->default(1);
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('project_id')->on('tf_projects')->onDelete('cascade');
			$table->integer('staff_id')->unsigned();
			$table->foreign('staff_id')->references('staff_id')->on('tf_staffs')->onDelete('cascade');
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
		Schema::drop('tf_project_properties');
	}

}
