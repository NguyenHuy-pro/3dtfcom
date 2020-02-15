<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfRuleBannerRanksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_rule_banner_ranks', function(Blueprint $table)
		{
			$table->increments('rule_id');
			$table->integer('salePrice')->default(0);
			$table->integer('saleMonth')->default(120);
			$table->integer('freeMonth')->default(120);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdded');
			$table->integer('rank_id')->unsigned();
			$table->foreign('rank_id')->references('rank_id')->on('tf_ranks')->onDelete('cascade');
			$table->integer('size_id')->unsigned();
			$table->foreign('size_id')->references('size_id')->on('tf_sizes')->onDelete('cascade');
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
		Schema::drop('tf_rule_banner_ranks');
	}

}
