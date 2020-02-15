<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfRelationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_relations', function(Blueprint $table)
		{
			$table->increments('relation_id');
			$table->string('name',30)->unique();
			$table->string('icon',50)->nullable();
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
		Schema::drop('tf_relations');
	}

}
