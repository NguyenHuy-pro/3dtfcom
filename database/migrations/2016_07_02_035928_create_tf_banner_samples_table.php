<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBannerSamplesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_banner_samples', function(Blueprint $table)
		{
			$table->increments('sample_id');
			$table->string('name',50)->unique();
			$table->string('image',100);
			$table->integer('border')->default(0);
			$table->tinyInteger('status')->default(1);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdded');
			$table->integer('size_id')->unsigned();
			$table->foreign('size_id')->references('size_id')->on('tf_sizes')->onDelete('cascade');
			$table->integer('staff_id')->unsigned();
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
		Schema::drop('tf_banner_samples');
	}

}
