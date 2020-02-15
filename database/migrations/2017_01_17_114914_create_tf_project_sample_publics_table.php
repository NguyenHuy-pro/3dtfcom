<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfProjectSamplePublicsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_project_sample_publics', function(Blueprint $table)
		{
			$table->increments('public_id');
			$table->integer('topPosition')->default(0);
			$table->integer('leftPosition')->default(0);
			$table->integer('zIndex')->default(0);
			$table->tinyInteger('publish')->default(1);
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('project_id')->on('tf_project_samples')->onDelete('cascade');
			$table->integer('sample_id')->unsigned();
			$table->foreign('sample_id')->references('sample_id')->on('tf_public_samples')->onDelete('cascade');
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
		Schema::drop('tf_project_sample_publics');
	}

}
