<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('th_name');
            $table->string('en_name');
            $table->integer('position_id')->unsigned();
            $table->foreign('position_id')->references('id')->on('members_positions');
            $table->integer('image_id')->unsigned();
            $table->foreign('image_id')->references('id')->on('uploads');
            $table->integer('level_id')->unsigned();
            $table->foreign('level_id')->references('id')->on('members_levels');
            $table->string('th_description')->nullable();
            $table->string('en_description')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('order_no')->nullable();
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
        Schema::dropIfExists('members');
    }
}
