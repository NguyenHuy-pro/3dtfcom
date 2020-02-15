<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBannerLicensesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_banner_licenses', function(Blueprint $table)
		{
			$table->increments('license_id');
			$table->string('name',20)->unique();
			$table->dateTime('dateBegin');
			$table->dateTime('dateEnd');
			$table->tinyInteger('status')->default(1);
			$table->tinyInteger('action')->default(1);
			$table->integer('banner_id')->unsigned();
			$table->foreign('banner_id')->references('banner_id')->on('tf_banners')->onDelete('cascade');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('user_id')->on('tf_users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_banner_licenses');
	}

}
