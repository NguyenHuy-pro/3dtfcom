<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfPaymentTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_payment_types', function(Blueprint $table)
		{
			$table->increments('type_id');
			$table->string('name',50)->unique();
			$table->text('description')->nullable();
			$table->tinyInteger('status')->default(1);
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
		Schema::drop('tf_payment_types');
	}

}
