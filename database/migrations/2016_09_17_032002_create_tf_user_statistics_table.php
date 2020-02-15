<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfUserStatisticsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_user_statistics', function(Blueprint $table)
		{
			$table->increments('statistic_id');
			$table->integer('friendNotifies')->default(0);
			$table->integer('actionNotifies')->default(0);
			$table->integer('friends')->default(0);
			$table->integer('buildings')->default(0);
			$table->integer('banners')->default(0);
			$table->integer('lands')->default(0);
			$table->integer('projects')->default(0);
			$table->integer('buildingFollows')->default(0);
			$table->integer('buildingSample')->default(0);
			$table->integer('friendRequests')->default(0);
			$table->integer('images')->default(0);
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('user_id')->on('tf_users')->onDelete('cascade');
			#$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_user_statistics');
	}

}
