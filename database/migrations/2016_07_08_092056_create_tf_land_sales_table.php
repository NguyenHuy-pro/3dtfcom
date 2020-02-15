<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfLandSalesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_land_sales', function(Blueprint $table)
		{
			$table->increments('sale_id');
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdded');
			$table->integer('land_id')->unsigned();
			$table->foreign('land_id')->references('land_id')->on('tf_lands')->onDelete('cascade');
			$table->integer('transactionStatus_id')->unsigned();
			$table->foreign('transactionStatus_id')->references('status_id')->on('tf_transaction_statuses')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_land_sales');
	}

}
