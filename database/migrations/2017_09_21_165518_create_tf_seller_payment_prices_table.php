<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfSellerPaymentPricesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_seller_payment_prices', function(Blueprint $table)
		{
			$table->increments('price_id');
			$table->integer('paymentPrice');
			$table->integer('shareValue');
			$table->integer('accessValue');
			$table->integer('registerValue');
			$table->tinyInteger('action')->default(1);
			$table->dateTime('created_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_seller_payment_prices');
	}

}
