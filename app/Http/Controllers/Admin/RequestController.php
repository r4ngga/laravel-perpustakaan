<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Http\Controllers\Controller;
use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    public function index(){

            $req = DB::table('book_requests')
            ->join('users', 'book_requests.id_user', '=', 'users.id_user')
            ->join('books', 'book_requests.id_book', '=', 'books.id_book')
            ->select('book_requests.*', 'users.*', 'books.*')
            ->orderBy('book_requests.time_request')
            ->orderBy('book_requests.id_user')
            ->get();
        return view('report.report_request', ['req' => $req]);

    }

    public function confirm(){

            $req = DB::table('book_requests')
            ->join('users', 'book_requests.id_user', '=', 'users.id_user')
            ->join('books', 'book_requests.id_book', '=', 'books.id_book')
            ->select('book_requests.*', 'users.*', 'books.*')
            ->orderBy('book_requests.time_request')
            ->orderBy('book_requests.id_user')
            ->get();
        // $req = DB::table('book_requests')->get();
        return view('transaction.confirm_request', ['req' => $req]);
    }

    public function update(Request $request)
    {

        $validateData = $request->validate([
            'status_request' => 'required',
        ]);
        DB::table('book_requests')->where('code_request', $request->code_request)
            ->update([
                'status_request' => $request->status_request,
            ]);

        return redirect('requestedbook')->with('notify', 'Successfully accept request a books by borrowers !');
    }
}
