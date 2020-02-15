<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_users', function(Blueprint $table)
		{
			$table->increments('user_id');
			$table->string('codeName',30);
			$table->string('firstName',30);
			$table->string('lastName',30);
			$table->string('account',100)->unique();
			$table->string('password',100);
			$table->date('birthday');
			$table->tinyInteger('gender');
			$table->rememberToken();
			$table->tinyInteger('confirm')->default(0);
			$table->tinyInteger('status')->default(0);
			$table->tinyInteger('action')->default(0);
			$table->dateTime('dateAdded');
			//$table->timestamps();
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
		Schema::drop('tf_users');
	}

}
