<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Book;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index(){
        $req = DB::table('book_requests')
        ->join('users', 'book_requests.id_user', '=', 'users.id_user')
        ->join('books', 'book_requests.id_book', '=', 'books.id_book')
        ->select('book_requests.*', 'users.*', 'books.*')
        ->where('book_requests.id_user', auth()->user()->id_user)
        ->orderBy('book_requests.time_request')
        ->orderBy('book_requests.id_user')
        ->get();

    $borrow = DB::table('book_borrows')
        ->join('detail_book_loans', 'book_borrows.code_borrow', '=', 'detail_book_loans.code_borrow')
        ->join('users', 'book_borrows.id_user', '=', 'users.id_user')
        ->join('books', 'detail_book_loans.id_book', '=', 'books.id_book')
        ->select('book_borrows.*', 'detail_book_loans.*', 'users.*', 'books.*')
        ->where('book_borrows.id_user', auth()->user()->id_user)
        ->orderBy('book_borrows.time_borrow')
        ->orderBy('detail_book_loans.number_borrow')
        ->get();
        return view('transaction.history', compact('req', 'borrow'));
    }

}
