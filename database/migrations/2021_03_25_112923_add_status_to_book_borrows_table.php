<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToBookBorrowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('book_borrows', function (Blueprint $table) {
            // $table->integer('stok')->after('pages_book');
            $table->date('time_return')->after('time_borrow');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('book_borrows', function (Blueprint $table) {
            $table->dropColumn('time_return');
        });
    }
}
