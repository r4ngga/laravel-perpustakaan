<?php

namespace App\Http\Controllers\Admin;

use App\Book;
use App\Book_Borrow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Log;

class AdminController extends Controller
{
    //
    public function index()
    {
        $users = User::where('role', 2)->get();
        $books = Book::all();
        $borrows = Book_Borrow::all();

        $countbook = $books->count();
        $countuser = $users->count();
        // dd($countbook, $countuser, $users);
        return view('admin.index', compact('users', 'books', 'countbook', 'countuser'));
    }

    public function countBook()
    {
        $books = Book::all();
        $countbook = $books->count();

        return response()->json(['count_book' => $countbook]);
        
    }

    public function countUser()
    {
        $users = User::where('role', 2)->get();
        $countuser = $users->count();

        return response()->json(['count_user' => $countuser]);
    }

    public function borrowBook()
    {
        $borrws = Book_Borrow::all();
        $countborrows = $borrws->count();

        return response()->json(['count_borrow' => $countborrows]);
    }
}
