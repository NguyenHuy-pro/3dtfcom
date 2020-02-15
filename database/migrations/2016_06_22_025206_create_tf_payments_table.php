<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfPaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_payments', function(Blueprint $table)
		{
			$table->increments('payment_id');
			$table->string('contactName',50)->nullable();
			$table->string('paymentName',50);
			$table->string('paymentCode',20);
			$table->tinyInteger('status')->default(1);
			$table->tinyInteger('action')->default(1);
			$table->integer('paymentType_id')->unsigned();
			$table->foreign('paymentType_id')->references('type_id')->on('tf_payment_types')->onDelete('cascade');
			$table->integer('bank_id')->unsigned()->nullable();
			$table->foreign('bank_id')->references('bank_id')->on('tf_banks')->onDelete('cascade');
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
		Schema::drop('tf_payments');
	}

}
