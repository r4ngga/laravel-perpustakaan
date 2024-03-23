<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Book;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
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
        return view('user.transaction.report_request', compact('req'));
    }

    public function requestallbook(){
        // $book = Book::all()->paginate(6);
        $book = Book::orderBy('created_at', 'desc')->paginate(6);
        return view('user.transaction.request_book', compact('book'));
    }

    public function requestbook($id)
    {
        // $book = Book::all();
        $book = Book::where('id_book', $id)->first();
        // $set_value = Str::random(7);
        $set_value = $this->generateRandomString(10);
        return view('user.transaction.applyrequest_book', compact('book', 'set_value'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code_request' => 'required',
            'id_user' => 'required',
            'id_book' => 'required',
            'time_request' => 'required',
        ]);
        $request_book = DB::table('book_requests')->insert([
            'code_request' => $request->code_request,
            'id_user' => $request->id_user,
            'id_book' => $request->id_book,
            'time_request' => $request->time_request,
            'status_request' => "request pending",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $user = User::where('id_user', $request->id_user)->first();
        $now = Carbon::now();

        $logs = new Log();
        $logs->user_id = $request->user_id;
        $logs->action = 'POST';
        $logs->description = 'request borrow a book';
        $logs->role = $user->role;
        $logs->data_old = "-";
        $logs->data_new = json_encode($request_book);
        $logs->log_time = $now;
        $logs->save();


        return redirect('/requestbook')->with('notify', 'Successfully request a books, please wait your request accept by admin !');
    }

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
        $auth = Auth::user();
        $req = DB::table('book_requests')
            ->join('users', 'book_requests.id_user', '=', 'users.id_user')
            ->join('books', 'book_requests.id_book', '=', 'books.id_book')
            ->select('book_requests.*', 'users.*', 'books.*')
            ->where('book_requests.id_user', $auth->id_user)
            ->get();

        return view('user.transaction.info_request', compact('req'));
    }

    private function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
