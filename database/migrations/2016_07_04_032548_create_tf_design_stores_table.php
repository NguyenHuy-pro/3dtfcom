<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfDesignStoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_design_stores', function(Blueprint $table)
		{
			$table->increments('design_id');
			$table->string('image',100);
			$table->tinyInteger('confirm')->default(0);
			$table->tinyInteger('valid')->default(0);
			$table->tinyInteger('status')->default(1);
			$table->dateTime('dateConfirm')->nullable();
			$table->dateTime('dateAdded');
			$table->integer('designReceive_id')->unsigned();
			$table->foreign('designReceive_id')->references('receive_id')->on('tf_design_receives')->onDelete('cascade');
			$table->integer('deisgnDirect_id')->unsigned();
			$table->foreign('deisgnDirect_id')->references('design_id')->on('tf_design_directs')->onDelete('cascade');
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
		Schema::drop('tf_design_stores');
	}

}
