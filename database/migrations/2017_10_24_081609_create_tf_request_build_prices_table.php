<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfRequestBuildPricesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_request_build_prices', function(Blueprint $table)
		{
			$table->increments('price_id');
			$table->integer('price');
			$table->tinyInteger('action')->default(1);
			$table->dateTime('created_at');
			$table->integer('size_id')->unsigned();
			$table->foreign('size_id')->references('size_id')->on('tf_sizes')->onDelete('cascade');
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
		Schema::drop('tf_request_build_prices');
	}

}
