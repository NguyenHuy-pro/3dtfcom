<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfProjectSalesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_project_sales', function(Blueprint $table)
		{
			$table->increments('sale_id');
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdded');
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('project_id')->on('tf_projects')->onDelete('cascade');
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
		Schema::drop('tf_project_sales');
	}

}
