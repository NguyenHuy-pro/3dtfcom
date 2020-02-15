<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfDesignRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_design_requests', function(Blueprint $table)
		{
			$table->increments('request_id');
			$table->string('image',100);
			$table->string('description',400);
			$table->integer('point');
			$table->tinyInteger('designObject')->default(1);
			$table->tinyInteger('confirm')->default(0);
			$table->tinyInteger('status')->default(1);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdded');
			$table->integer('size_id')->unsigned();
			$table->foreign('size_id')->references('size_id')->on('tf_sizes')->onDelete('cascade');
			$table->integer('businessType_id')->unsigned();
			$table->foreign('businessType_id')->references('type_id')->on('tf_business_types')->onDelete('cascade');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('user_id')->on('tf_users')->onDelete('cascade');
			$table->integer('staffConfirm_id')->unsigned();
			$table->foreign('staffConfirm_id')->references('staff_id')->on('tf_staffs')->onDelete('cascade');
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
		Schema::drop('tf_design_requests');
	}

}
