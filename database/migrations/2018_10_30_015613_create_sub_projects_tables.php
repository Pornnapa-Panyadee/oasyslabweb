<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubProjectsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('main_id')->unsigned();
            $table->foreign('main_id')->references('id')->on('projects');
            $table->string('th_name');
            $table->string('en_name');
            $table->text('th_description');
            $table->text('en_description');
            $table->string('external_path')->nullable();
            $table->integer('image_id')->unsigned();
            $table->foreign('image_id')->references('id')->on('uploads');
            $table->integer('order_no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_projects');
    }
}
