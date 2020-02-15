<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfUserContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_user_contacts', function(Blueprint $table)
		{
			$table->increments('contact_id');
			$table->string('address',30);
			$table->string('phone',50);
			$table->string('email',225);
			$table->tinyInteger('status')->default(1);
			$table->dateTime('dateAdded');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('user_id')->on('tf_users')->onDelete('cascade');
			$table->integer('province_id')->unsigned()->nullable();
			$table->foreign('province_id')->references('province_id')->on('tf_provinces')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_user_contacts');
	}

}
