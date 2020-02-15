<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfStaffAccessesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_staff_accesses', function(Blueprint $table)
		{
			$table->increments('access_id');
			$table->string('accessIP',30);
			$table->tinyInteger('accessStatus')->default(1);
			$table->dateTime('accessDate');
			$table->tinyInteger('action')->default(1);
			$table->integer('staff_id')->unsigned();
			$table->foreign('staff_id')->references('staff_id')->on('tf_staffs')->onDelete('cascade');
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
		Schema::drop('tf_staff_accesses');
	}

}
