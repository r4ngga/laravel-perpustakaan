<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Book;
use App\Book_Borrow;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ReturnsController extends Controller
{

    public function index()
    {
        $borrowers = DB::table('book_borrows')
            ->get();
        return view('admin.transaction.returned_book', ['borrow' => $borrowers]);
    }

    public function store(Request $request)
    {
        $auth = Auth::user();
        $validateData = $request->validate([
            'status' => 'required',
        ]);

        $old_request = Book_Borrow::where('code_borrow', $request->code_borrow)->first();

        $new_request = DB::table('book_borrows')->where('code_borrow', $request->code_borrow)
            ->update([
                'status' => $request->status,
            ]);
        
        $now = Carbon::now();

        $log = new Log();
        $log->user_id = $auth->id_user;
        $log->action = 'PUT';
        $log->description = 'update books return';
        $log->role = $auth->role;
        $log->log_time = $now;
        $log->data_old = json_encode($old_request);
        $log->data_new = json_encode($new_request);
        $log->save();
        return redirect('/returnedbook')->with('notify', 'Successfully return a books !');
    }
}
