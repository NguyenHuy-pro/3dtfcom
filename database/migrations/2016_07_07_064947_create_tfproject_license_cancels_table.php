<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfProjectLicenseCancelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tfProject_license_cancels', function(Blueprint $table)
		{
			$table->increments('cancel_id');
			$table->string('notifyContent',200);
			$table->string('reason',200);
			$table->dateTime('dateAdded');
			$table->integer('projectLicense_id')->unsigned();
			$table->foreign('projectLicense_id')->references('license_id')->on('tf_project_licenses')->onDelete('cascade');
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
		Schema::drop('tfproject_license_cancels');
	}

}
