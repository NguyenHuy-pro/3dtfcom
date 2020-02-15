<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfLandRequestBuildDesignsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_land_request_build_designs', function(Blueprint $table)
		{
			$table->increments('design_id');
			$table->string('image',200);
			$table->dateTime('deliveryDate');
			$table->tinyInteger('confirm')->default(0);
			$table->tinyInteger('publish')->default(0);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('created_at');
			$table->integer('request_id')->unsigned();
			$table->foreign('request_id')->references('request_id')->on('tf_land_request_builds')->onDelete('cascade');
			$table->integer('staff_id')->unsigned();
			$table->foreign('staff_id')->references('staff_id')->on('tf_staffs')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_land_request_build_designs');
	}

}
