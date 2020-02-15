<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfSellersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_sellers', function(Blueprint $table)
		{
			$table->increments('seller_id');
			$table->string('sellerCode',30);
			$table->dateTime('beginDate');
			$table->integer('landShare')->default(0);
			$table->integer('landShareAccess')->default(0);
			$table->integer('landShareRegister')->default(0);
			$table->integer('bannerShare')->default(0);
			$table->integer('bannerShareAccess')->default(0);
			$table->integer('bannerShareRegister')->default(0);
			$table->integer('buildingShare')->default(0);
			$table->integer('buildingShareAccess')->default(0);
			$table->integer('buildingRegister')->default(0);
			$table->tinyInteger('status')->default(1);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('created_at');
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
		Schema::drop('tf_sellers');
	}

}
