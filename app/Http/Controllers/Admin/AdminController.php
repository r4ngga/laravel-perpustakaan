<?php

namespace App\Http\Controllers\Admin;

use App\Book;
use App\Book_Borrow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

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
}
