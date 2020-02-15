<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfRuleProjectRanksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_rule_project_ranks', function(Blueprint $table)
		{
			$table->increments('rule_id');
			$table->integer('salePrice')->default(0);
			$table->integer('saleMonth')->default(120);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdded');
			$table->integer('rank_id')->unsigned();
			$table->foreign('rank_id')->references('rank_id')->on('tf_ranks')->onDelete('cascade');
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
		Schema::drop('tf_rule_project_ranks');
	}

}
