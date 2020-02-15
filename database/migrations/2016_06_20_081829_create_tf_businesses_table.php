<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBusinessesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_businesses', function(Blueprint $table)
		{
			$table->increments('business_id');
			$table->string('name',30)->unique();
			$table->text('description')->nullable();
			$table->tinyInteger('status')->default(1);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdd');
			$table->integer('businessType_id')->unsigned();
			$table->foreign('businessType_id')->references('type_id')->on('tf_business_types')->onDelete('cascade');
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
		Schema::drop('tf_businesses');
	}

}
