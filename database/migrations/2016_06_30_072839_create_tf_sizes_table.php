<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfSizesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_sizes', function(Blueprint $table)
		{
			$table->increments('size_id');
			$table->string('name',30)->unique();
			$table->integer('width');
			$table->integer('height');
			$table->string('image',50);
			$table->tinyInteger('status')->default(1);
			$table->integer('standard_id')->unsigned();
			$table->foreign('standard_id')->references('standard_id')->on('tf_standards')->onDelete('cascade');
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
		Schema::drop('tf_sizes');
	}

}
