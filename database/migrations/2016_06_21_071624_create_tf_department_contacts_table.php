<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfDepartmentContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_department_contacts', function(Blueprint $table)
		{
			$table->increments('contact_id');
			$table->string('email',65);
			$table->string('phone',50);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdd');
			$table->integer('department_id')->unsigned();
			$table->foreign('department_id')->references('department_id')->on('tf_departments')->onDelete('cascade');
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
		Schema::drop('tf_department_contacts');
	}

}
