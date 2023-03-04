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
            $table->id();
            $table->bigIncrements('number_borrow');
            // $table->unsignedS('code_borrowed');
            $table->string('code_borrow', 20)->nullable();
            $table->unsignedInteger('borrow_id')->index('fk_book_borrows_detail_book_loans_01');
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
