<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Http\Controllers\Controller;
use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){
        $user = Auth::user();

        return view('user.index', compact('user'));
    }

    public function edit(){
        $user = Auth::user();
        $getUser = User::where('id_user', $user->id_user)->first();
        dd($getUser);
        return view('setting');
    }

    public function fetchCountBook()
    {
        $books = Book::all();
        $countbook = count($books);

        return response()->json($countbook);
    }

    public function fetchCountRequest()
    {
        $auth = Auth::user();
        $req = DB::table('book_requests')
        ->join('users', 'book_requests.id_user', '=', 'users.id_user')
        ->join('books', 'book_requests.id_book', '=', 'books.id_book')
        ->select('book_requests.*', 'users.*', 'books.*')
        ->where('book_requests.id_user', $auth->id_user)
        ->orderBy('book_requests.time_request')
        ->orderBy('book_requests.id_user')
        ->get();

        $countrequest = count($req);

        return response()->json($countrequest);
        //
    }

    public function fetchCountBorrow()
    {
        //
        $auth = Auth::user();
        $borrow = DB::table('book_borrows')
        ->join('detail_book_loans', 'book_borrows.code_borrow', '=', 'detail_book_loans.code_borrow')
        ->join('users', 'book_borrows.id_user', '=', 'users.id_user')
        ->join('books', 'detail_book_loans.id_book', '=', 'books.id_book')
        ->select('book_borrows.*', 'detail_book_loans.*', 'users.*', 'books.*')
        ->where('book_borrows.id_user', $auth->id_user)
        ->orderBy('book_borrows.time_borrow')
        ->orderBy('detail_book_loans.number_borrow')
        ->get();

        $countborrow = count($borrow);

        return response()->json($countborrow);
    }

}
