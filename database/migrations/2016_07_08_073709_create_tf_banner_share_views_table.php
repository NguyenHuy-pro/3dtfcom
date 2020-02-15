<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBannerShareViewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_banner_share_views', function(Blueprint $table)
		{
			$table->increments('view_id');
			$table->string('accessIP',30);
			$table->tinyInteger('register')->default(0);
			$table->dateTime('dateAdded');
			$table->integer('bannerShare_id')->unsigned();
			$table->foreign('bannerShare_id')->references('share_id')->on('tf_banner_shares')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_banner_share_views');
	}

}
