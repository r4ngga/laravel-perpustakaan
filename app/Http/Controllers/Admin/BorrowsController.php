<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Book;
use Illuminate\Support\Facades\DB;
use App\Book_Borrow;
use App\Detail_Book_Loan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Symfony\Component\Console\Input\Input as InputInput;

class BorrowsController extends Controller
{

    public function index()
    {
        $borrow = DB::table('book_borrows')
            ->join('detail_book_loans', 'book_borrows.code_borrow', '=', 'detail_book_loans.code_borrow')
            ->join('users', 'book_borrows.id_user', '=', 'users.id_user')
            ->join('books', 'detail_book_loans.id_book', '=', 'books.id_book')
            ->select('book_borrows.*', 'detail_book_loans.*', 'users.*', 'books.*')
            ->orderBy('book_borrows.time_borrow')
            ->orderBy('detail_book_loans.number_borrow')
            ->get();
        // $borrow = DB::table('book_borrow')->get();

        return view('report.report_borrow', ['borrow' => $borrow]);
    }

    public function borrowed_book()
    {
        $set_value = Str::random(7);
        $book = Book::all();
        $user = User::all();
        return view('transaction.borrowed_book', ['book' => $book, 'user' => $user, 'set_value' => $set_value]);
    }

    public function store(Request $request, Book $book)
    {
        $validateData = $request->validate([
            'code_borrowed' => 'required',
            'code_borrow' => 'required',
            'id_user' => 'required',
            'time_borrow' => 'required',
            'time_return' => 'required',
        ]);

        $validatedetail = $request->validate([
            'code_borrowed' => 'required',
            'id_book' => 'required',
        ]);
        DB::table('book_borrows')->insert([
            'code_borrow' => $request->code_borrow,
            'id_user' => $request->id_user,
            'time_borrow' => $request->time_borrow,
            'time_return' => $request->time_return,
            'status' => "borrow",
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $cdborrow = $request->input('code_borrowed');
        $idbook = $request->id_book;
        $quantity = $request->qty;
        foreach ($cdborrow as $code => $value) {
            DB::table('detail_book_loans')->insert([
                'code_borrow' => $value,
                'id_book' => $idbook[$code],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
        // $sisastok = $request->stok;
        // $count_book = count($request->id_book);
        // for ($x = 0; $x < $count_book; $x++) {
        //     DB::table('books')->where('id_book', [$request->id_book[$x]])
        //         ->update(['stok' => $request->stok[$x]]);
        // }

        return redirect('/borrowedbook')->with('notify', 'Successfully borrow a books !');
    }
}
