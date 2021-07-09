<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_th');
            $table->string('title_en');
            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('articles_type');
            $table->string('cover_path')->nullable();
            $table->integer('cover_id')->unsigned()->nullable();
            $table->foreign('cover_id')->references('id')->on('uploads');
            $table->text('detail_th')->nullable();
            $table->text('detail_en')->nullable();
            $table->integer('order_no')->nullable();
            $table->boolean('completed');
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
        Schema::dropIfExists('articles');
    }
}
