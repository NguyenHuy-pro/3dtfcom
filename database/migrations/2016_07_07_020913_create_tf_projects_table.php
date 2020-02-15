<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfProjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_projects', function(Blueprint $table)
		{
			$table->increments('project_id');
			$table->string('nameCode',30)->unique();
			$table->string('name',50)->unique();
			$table->string('shortDescription',200);
			$table->text('description')->nullable();
			$table->integer('pointValue')->default(0);
			$table->tinyInteger('defaultCenter')->default(0);
			$table->tinyInteger('status')->default(1);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdded');
			$table->integer('province_id')->unsigned();
			$table->foreign('province_id')->references('province_id')->on('tf_provinces')->onDelete('cascade');
			$table->integer('area_id')->unsigned();
			$table->foreign('area_id')->references('area_id')->on('tf_areas')->onDelete('cascade');
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
		Schema::drop('tf_projects');
	}

}
