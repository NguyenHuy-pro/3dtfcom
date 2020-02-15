<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfRechargesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_recharges', function(Blueprint $table)
		{
			$table->increments('recharge_id');
			$table->string('code',30);
			$table->integer('point')->default(0);
			$table->integer('totalPayment')->default(0);
			$table->tinyInteger('confirm')->default(0);
			$table->integer('status')->default(1);
			$table->dateTime('dateAdded');
			$table->integer('card_id')->unsigned();
			$table->foreign('card_id')->references('card_id')->on('tf_user_cards')->onDelete('cascade');
			$table->integer('payment_id')->unsigned();
			$table->foreign('payment_id')->references('payment_id')->on('tf_payments')->onDelete('cascade');
			$table->integer('pointType_id')->unsigned();
			$table->foreign('pointType_id')->references('type_id')->on('tf_point_types')->onDelete('cascade');
			$table->integer('staff_id')->unsigned()->nullable();
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
		Schema::drop('tf_recharges');
	}

}
