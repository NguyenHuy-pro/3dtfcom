<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfSellerPaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_seller_payments', function(Blueprint $table)
		{
			$table->increments('payment_id');
			$table->string('paymentCode',30);
			$table->dateTime('fromDate');
			$table->dateTime('toDate');
			$table->integer('totalAccess')->default(0);
			$table->integer('totalRegister')->default(0);
			$table->integer('totalPay')->default(0);
			$table->tinyInteger('payStatus')->default(0);
			$table->tinyInteger('status')->default(1);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('created_at');
			$table->integer('seller_id')->unsigned();
			$table->foreign('seller_id')->references('seller_id')->on('tf_sellers')->onDelete('cascade');
			$table->integer('price_id')->unsigned();
			$table->foreign('price_id')->references('price_id')->on('tf_seller_payment_prices')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_seller_payments');
	}

}
