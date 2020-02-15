<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfPointTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_point_transactions', function(Blueprint $table)
		{
			$table->increments('transaction_id');
			$table->integer('pointValue');
			$table->integer('usdValue');
			$table->dateTime('dateApply');
			$table->tinyInteger('action')->default(1);
			$table->integer('pointType_id')->unsigned();
			$table->foreign('pointType_id')->references('type_id')->on('tf_point_types')->onDelete('cascade');
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
		Schema::drop('tf_point_transactions');
	}

}
