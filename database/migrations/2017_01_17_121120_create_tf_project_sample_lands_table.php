<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfProjectSampleLandsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_project_sample_lands', function(Blueprint $table)
		{
			$table->increments('land_id');
			$table->integer('topPosition')->default(0);
			$table->integer('leftPosition')->default(0);
			$table->integer('zIndex')->default(0);
			$table->tinyInteger('publish')->default(1);
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('project_id')->on('tf_project_samples')->onDelete('cascade');
			$table->integer('size_id')->unsigned();
			$table->foreign('size_id')->references('size_id')->on('tf_sizes')->onDelete('cascade');
			$table->integer('transactionStatus_id')->unsigned();
			$table->foreign('transactionStatus_id')->references('status_id')->on('tf_transaction_statuses')->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_project_sample_lands');
	}

}
