<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Http\Controllers\Controller;
use App\Book;
use App\Book_Request;
use App\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        return view('admin.report.report_request', ['req' => $req]);

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

        return view('admin.transaction.confirm_request', compact('req'));
    }

    public function update(Request $request)
    {

        $auth = Auth::user();

        $validateData = $request->validate([
            'status_request' => 'required',
        ]);
        $old_data = Book_Request::where('code_request', $request->code_request)->first();
        $update_requestbook = DB::table('book_requests')->where('code_request', $request->code_request)
            ->update([
                'status_request' => $request->status_request,
            ]);
        
        $get_book = DB::table('books')->where('id', $update_requestbook->id_book)->first();
        $total_book = $get_book->stok - $request->stok;

        $book_update = DB::table('books')
        ->where('id', $update_requestbook->id_book)
        ->update([
            'stok' => $total_book,
        ]);
        
        $now = Carbon::now();
        
        $logs = new Log();
        $logs->id_user = $auth->id_user;
        $logs->update = 'PUT';
        $logs->description = 'update request books';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = json_encode($old_data);
        $logs->data_new = json_encode($update_requestbook);
        $logs->save();

        $booklogs = new Log();
        $booklogs->id_user = $auth->id_user;
        $booklogs->update = 'PUT';
        $booklogs->description = 'update stok books';
        $booklogs->log_time = $now;
        $booklogs->data_old = '-';
        $booklogs->data_new = json_encode($book_update);
        $booklogs->save();

        return redirect('requestedbook')->with('notify', 'Successfully accept request a books by borrowers !');
    }
}
