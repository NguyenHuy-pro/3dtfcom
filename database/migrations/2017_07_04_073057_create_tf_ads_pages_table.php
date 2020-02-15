<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfAdsPagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_ads_pages', function(Blueprint $table)
		{
			$table->increments('page_id');
			$table->string('name',30)->unique();
			$table->tinyInteger('status')->default(1);
			$table->tinyInteger('action')->default(1);
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
		Schema::drop('tf_ads_pages');
	}

}
