<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfDesignRequestStylesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_design_request_styles', function(Blueprint $table)
		{
			$table->integer('request_id')->unsigned();
			$table->foreign('request_id')->references('request_id')->on('tf_design_requests')->onDelete('cascade');
			$table->integer('style_id')->unsigned();
			$table->foreign('style_id')->references('style_id')->on('tf_design_styles')->onDelete('cascade');
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
		Schema::drop('tf_design_request_styles');
	}

}
