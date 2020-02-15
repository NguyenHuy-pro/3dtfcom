<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfDesignDirectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_design_directs', function(Blueprint $table)
		{
			$table->increments('deisgn_id');
			$table->tinyInteger('designObject')->default(1);
			$table->integer('receivePoint');
			$table->tinyInteger('action')->default(1);
			$table->integer('size_id')->unsigned();
			$table->foreign('size_id')->references('size_id')->on('tf_sizes')->onDelete('cascade');
			$table->integer('businessType_id')->unsigned();
			$table->foreign('businessType_id')->references('type_id')->on('tf_business_types')->onDelete('cascade');
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
		Schema::drop('tf_design_directs');
	}

}
