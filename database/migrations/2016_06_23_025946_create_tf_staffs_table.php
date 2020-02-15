<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfStaffsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_staffs', function(Blueprint $table)
		{
			$table->increments('staff_id');
			$table->string('nameCode',20)->unique();
			$table->string('firstName',30);
			$table->string('lastName',20);
			$table->string('alias',100)->unique();
			$table->string('account',65)->unique();
			$table->string('password', 100);
			$table->string('birthday',100);
			$table->tinyInteger('gender');
			$table->string('image',100);
			$table->string('address',100);
			$table->string('phone',30);
			$table->tinyInteger('level')->default(2);
			$table->tinyInteger('type')->default(2);
			$table->tinyInteger('new')->default(1);
			$table->tinyInteger('confirm')->default(0);
			$table->tinyInteger('status')->default(1);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdd');
			$table->integer('staffAdd_id')->unsigned()->nullable();
			$table->foreign('staffAdd_id')->references('staff_id')->on('tf_staffs');
			$table->integer('department_id')->unsigned();
			$table->foreign('department_id')->references('department_id')->on('tf_departments')->onDelete('cascade');
			$table->integer('province_id')->unsigned()->nullable();
			$table->foreign('province_id')->references('province_id')->on('tf_provinces')->onDelete('cascade');
			$table->rememberToken();
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
		Schema::drop('tf_staffs');
	}

}
