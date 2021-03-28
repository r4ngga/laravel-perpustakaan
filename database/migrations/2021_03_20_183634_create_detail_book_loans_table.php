<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailBookLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_book_loans', function (Blueprint $table) {
            $table->bigIncrements('number_borrow');
            // $table->unsignedS('code_borrowed');
            $table->string('code_borrow', 20)->nullable();
            $table->unsignedBigInteger('id_book');
            $table->foreign('id_book')->references('id_book')->on('books');
            $table->integer('qty');
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
        Schema::dropIfExists('detail_book_loans');
    }
}
