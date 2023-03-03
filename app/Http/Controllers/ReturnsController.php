<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Book;
use App\Book_Borrow;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class ReturnsController extends Controller
{

    public function index()
    {
        $borrowers = DB::table('book_borrows')
            ->get();
        return view('transaction.returned_book', ['borrow' => $borrowers]);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'status' => 'required',
        ]);

        DB::table('book_borrows')->where('code_borrow', $request->code_borrow)
            ->update([
                'status' => $request->status,
            ]);
        return redirect('/returnedbook')->with('notify', 'Successfully return a books !');
    }
}
