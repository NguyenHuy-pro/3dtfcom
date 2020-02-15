<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfDesignReceivesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_design_receives', function(Blueprint $table)
		{
			$table->increments('receive_id');
			$table->dateTime('dateBegin');
			$table->dateTime('dateEnd');
			$table->integer('receivePoint');
			$table->tinyInteger('complete')->default(0);
			$table->tinyInteger('status')->default(1);
			$table->tinyInteger('action')->default(1);
			$table->integer('request_id')->unsigned();
			$table->foreign('request_id')->references('request_id')->on('tf_design_requests')->onDelete('cascade');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('user_id')->on('tf_users')->onDelete('cascade');
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
		Schema::drop('tf_design_receives');
	}

}
