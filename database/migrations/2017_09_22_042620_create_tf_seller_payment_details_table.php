<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfSellerPaymentDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_seller_payment_details', function(Blueprint $table)
		{
			$table->increments('detail_id');
			$table->dateTime('created_at');
			$table->integer('payment_id')->unsigned();
			$table->foreign('payment_id')->references('payment_id')->on('tf_seller_payments')->onDelete('cascade');
			$table->integer('info_id')->unsigned();
			$table->foreign('info_id')->references('info_id')->on('tf_seller_payment_infos')->onDelete('cascade');
			$table->integer('staff_id')->unsigned();
			$table->foreign('staff_id')->references('staff_id')->on('tf_staffs')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_seller_payment_details');
	}

}
