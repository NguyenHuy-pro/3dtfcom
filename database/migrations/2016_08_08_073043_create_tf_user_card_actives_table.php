<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfUserCardActivesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_user_card_actives', function(Blueprint $table)
		{
			$table->increments('active_id');
			$table->integer('current')->default(0);
			$table->integer('increase')->default(0);
			$table->integer('decrease')->default(0);
			$table->string('reason',150);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdded');
			$table->integer('card_id')->unsigned();
			$table->foreign('card_id')->references('card_id')->on('tf_user_cards')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_user_card_actives');
	}

}
