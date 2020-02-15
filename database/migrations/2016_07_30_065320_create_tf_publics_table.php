<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfPublicsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_publics', function(Blueprint $table)
		{
			$table->increments('public_id');
			$table->string('name',30)->unique();
			$table->integer('topPosition')->default(0);
			$table->integer('leftPosition')->default(0);
			$table->integer('zindex')->default(0);
			$table->tinyInteger('publish')->default(1);
			$table->tinyInteger('status')->default(1);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdded');
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('project_id')->on('tf_projects')->onDelete('cascade');
			$table->integer('publicSample_id')->unsigned();
			$table->foreign('publicSample_id')->references('sample_id')->on('tf_public_samples')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_publics');
	}

}
