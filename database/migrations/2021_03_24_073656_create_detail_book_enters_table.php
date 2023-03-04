<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailBookEntersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_book_enters', function (Blueprint $table) {
            $table->id();
            $table->bigIncrements('number_returns');
            $table->string('code_return', 20)->nullable();
            $table->unsignedBigInteger('id_book');
            $table->foreign('id_book')->references('id_book')->on('books');
            $table->integer('qty_return');
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
        Schema::dropIfExists('detail_book_enters');
    }
}
