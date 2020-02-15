<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBanksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_banks', function(Blueprint $table)
		{
			$table->increments('bank_id');
			$table->string('name',50)->unique();
			$table->string('image',100);
			$table->tinyInteger('status')->default(1);
			$table->dateTime('dateAdd');
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
		Schema::drop('tf_banks');
	}

}
