<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBuildingShareViewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_building_share_views', function(Blueprint $table)
		{
			$table->increments('view_id');
			$table->string('accessIP',30);
			$table->tinyInteger('register')->default(0);
			$table->dateTime('dateAdded');
			$table->integer('buildingShare_id')->unsigned();
			$table->foreign('buildingShare_id')->references('share_id')->on('tf_building_shares')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_buildin_share_views');
	}

}
