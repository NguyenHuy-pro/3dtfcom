<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfSellerGuideObjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_seller_guide_objects', function(Blueprint $table)
		{
			$table->increments('object_id');
			$table->string('name',50)->unique();
			$table->tinyInteger('status')->default(1);
			$table->tinyInteger('action')->default(1);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_seller_guide_objects');
	}

}
