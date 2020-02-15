<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfProjectSamplesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_project_samples', function(Blueprint $table)
		{
			$table->increments('project_id');
			$table->string('code',30)->unique();
			$table->string('description', 20);
			$table->string('image', 20);
			$table->tinyInteger('build')->default(0);
			$table->tinyInteger('confirm')->default(0);
			$table->tinyInteger('valid')->default(0);
			$table->tinyInteger('publish')->default(0);
			$table->tinyInteger('status')->default(1);
			$table->tinyInteger('action')->default(1);
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
		Schema::drop('tf_project_samples');
	}

}
