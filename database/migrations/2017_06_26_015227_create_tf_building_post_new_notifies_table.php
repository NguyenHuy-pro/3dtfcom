<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBuildingPostNewNotifiesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tf_building_post_new_notifies', function (Blueprint $table) {
            $table->integer('post_id')->unsigned();
            $table->foreign('post_id')->references('post_id')->on('tf_building_posts')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('user_id')->on('tf_users')->onDelete('cascade');
            $table->tinyInteger('newInfo')->default(1);
            $table->tinyInteger('displayNotify')->default(1);
            $table->tinyInteger('action')->default(1);
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tf_building_post_new_notifies');
    }

}
