<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Book;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class RequestsController extends Controller
{

    public function index()
    {
        $req = DB::table('book_requests')
            ->join('users', 'book_requests.id_user', '=', 'users.id_user')
            ->join('books', 'book_requests.id_book', '=', 'books.id_book')
            ->select('book_requests.*', 'users.*', 'books.*')
            ->orderBy('book_requests.time_request')
            ->orderBy('book_requests.id_user')
            ->get();
        return view('report.report_request', ['req' => $req]);
    }

    public function requestallbook(){
        // $book = Book::all()->paginate(6);
        $book = Book::orderBy('created_at', 'desc')->paginate(6);
        return view('transaction.request_book', ['book' => $book]);
    }

    public function requestbook(Book $book)
    {
        // $book = Book::all();
        $set_value = Str::random(7);
        return view('transaction.applyrequest_book', compact('book'), ['set_value' => $set_value]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code_request' => 'required',
            'id_user' => 'required',
            'id_book' => 'required',
            'time_request' => 'required',
        ]);
        DB::table('book_requests')->insert([
            'code_request' => $request->code_request,
            'id_user' => $request->id_user,
            'id_book' => $request->id_book,
            'time_request' => $request->time_request,
            'status_request' => "request pending",
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        //$logs = new Log();
        //$logs->user_id = $user->user_id;
       //$logs->action = 'POST';
        //$logs->description = 'login system';
        //$logs->role = $user->role;
        //$logs->log_time = $now;
        //$logs->save();


        return redirect('/requestbook')->with('notify', 'Successfully request a books, please wait your request accept by admin !');
    }

    // public function confirm() // -> to update in requestcontroller (admin)
    // {
    //     $req = DB::table('book_requests')
    //         ->join('users', 'book_requests.id_user', '=', 'users.id_user')
    //         ->join('books', 'book_requests.id_book', '=', 'books.id_book')
    //         ->select('book_requests.*', 'users.*', 'books.*')
    //         ->orderBy('book_requests.time_request')
    //         ->orderBy('book_requests.id_user')
    //         ->get();
    //     // $req = DB::table('book_requests')->get();
    //     return view('transaction.confirm_request', ['req' => $req]);
    // }

    // public function change(Request $request) // -> to update in requestcontroller (admin)
    // {
    //     $validateData = $request->validate([
    //         'status_request' => 'required',
    //     ]);
    //     DB::table('book_requests')->where('code_request', $request->code_request)
    //         ->update([
    //             'status_request' => $request->status_request,
    //         ]);

    //     return redirect('requestedbook')->with('notify', 'Successfully accept request a books by borrowers !');
    // }

    public function show(User $user)
    {

        $req = DB::table('book_requests')
            ->join('users', 'book_requests.id_user', '=', 'users.id_user')
            ->join('books', 'book_requests.id_book', '=', 'books.id_book')
            ->select('book_requests.*', 'users.*', 'books.*')
            ->where('book_requests.id_user', auth()->user()->id_user)
            ->get();

        return view('user.info_request', compact('req'));
    }
}
