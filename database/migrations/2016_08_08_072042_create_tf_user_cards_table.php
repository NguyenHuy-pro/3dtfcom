<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfUserCardsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_user_cards', function(Blueprint $table)
		{
			$table->increments('card_id');
			$table->string('name')->unique();
			$table->integer('pointValue')->default(0);
			$table->tinyInteger('status')->default(1);
			$table->dateTime('dateAdded');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('user_id')->on('tf_users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_user_cards');
	}

}
