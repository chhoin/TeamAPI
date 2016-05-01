<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_articles', function (Blueprint $table) {
            $table->increments('art_id');
            $table->string('title','255');
            $table->text('description');
            $table->string('image','255');
            $table->integer('cat_id_for')->unsigned();
            $table->date('created_at');
            $table->date('updated_at');

            $table->foreign('cat_id_for')->references('cat_id')->on('tbl_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_articles');
    }
}
