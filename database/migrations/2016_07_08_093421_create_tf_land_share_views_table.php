<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfLandShareViewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_land_share_views', function(Blueprint $table)
		{
			$table->increments('view_id');
			$table->string('accessIP',30);
			$table->tinyInteger('register')->default(0);
			$table->dateTime('dateAdded');
			$table->integer('landShare_id')->unsigned();
			$table->foreign('landShare_id')->references('share_id')->on('tf_land_shares')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_land_share_views');
	}

}
