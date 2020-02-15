<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfProjectIconsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_project_icons', function(Blueprint $table)
		{
			$table->increments('icon_id');
			$table->integer('topPosition')->default(0);
			$table->integer('leftPosition')->default(0);
			$table->tinyInteger('action')->default(1);
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('project_id')->on('tf_projects')->onDelete('cascade');
			$table->integer('iconSample_id')->unsigned();
			$table->foreign('iconSample_id')->references('sample_id')->on('tf_project_icon_samples')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_project_icons');
	}

}
