<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfSellerPaymentInfosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_seller_payment_infos', function(Blueprint $table)
		{
			$table->increments('info_id');
			$table->string('name',50);
			$table->string('paymentCode',30);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('created_at');
			$table->integer('seller_id')->unsigned();
			$table->foreign('seller_id')->references('seller_id')->on('tf_sellers')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_seller_payment_infos');
	}

}
