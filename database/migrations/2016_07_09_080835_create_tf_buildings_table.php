<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBuildingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_buildings', function(Blueprint $table)
		{
			$table->increments('building_id');
			$table->string('nameCode',30)->unique();
			$table->string('name',50);
			$table->string('alias',100)->unique();
			$table->string('shortDescription',200);
			$table->text('description')->nullable();
			$table->string('website',200)->nullable();
			$table->string('phone',50)->nullable();
			$table->string('address',150)->nullable();
			$table->string('email',100)->nullable();
			$table->integer('pointValue')->default(0);
			$table->tinyInteger('status')->default(1);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdded');
			$table->integer('buildingSample_id')->unsigned();
			$table->foreign('buildingSample_id')->references('sample_id')->on('tf_building_samples')->onDelete('cascade');
			$table->integer('land_id')->unsigned();
			$table->foreign('land_id')->references('land_id')->on('tf_lands')->onDelete('cascade');
			$table->integer('postRelation_id')->unsigned();
			$table->foreign('postRelation_id')->references('relation_id')->on('tf_relations')->onDelete('cascade');
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
		Schema::drop('tf_buildings');
	}

}
