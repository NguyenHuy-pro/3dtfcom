<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBannersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_banners', function(Blueprint $table)
		{
			$table->increments('banner_id');
			$table->string('name',30)->unique();
			$table->integer('topPosition')->default(0);
			$table->integer('leftPosition')->default(0);
			$table->integer('zindex')->default(0);
			$table->integer('pointValue')->default(0);
			$table->tinyInteger('publish')->default(0);
			$table->tinyInteger('status')->default(1);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdded');
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('project_id')->on('tf_projects')->onDelete('cascade');
			$table->integer('bannerSample_id')->unsigned();
			$table->foreign('bannerSample_id')->references('sample_id')->on('tf_banner_samples')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_banners');
	}

}
