<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfSellerGuidesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_seller_guides', function(Blueprint $table)
		{
			$table->increments('guide');
			$table->text('content');
			$table->string('video')->nullable();
			$table->tinyInteger('status')->default(1);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('created_at');
			$table->integer('object_id')->unsigned();
			$table->foreign('object_id')->references('object_id')->on('tf_seller_guide_objects')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_seller_guides');
	}

}
