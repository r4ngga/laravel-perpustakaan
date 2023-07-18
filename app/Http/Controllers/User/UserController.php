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

        //getting count a request book

        return view('user.index', compact('user'));
    }

    public function edit(){
        $user = Auth::user();
        $getUser = User::where('id_user', $user->id_user)->first();
        dd($getUser);
        return view('setting');
    }

    //move to admin
    // public function fetchEdit($id){
    //     $users = User::findOrfail($id);
    //     $json_encode = json_encode($users);

    //     return $json_encode;
    // } ///move to admin

    //move to admin
    // public function update(Request $request){
    //     $request->validate([
    //         'name' => 'required',
    //         'password' => 'required',
    //         'email' => 'required',
    //         'address' => 'required',
    //         'phone_number' => 'required',
    //         'gender' => 'required',
    //     ]);

    //     $user = User::where('id_user', auth()->user()->id_user)->first();
    //     $user->name = $request->name;
    //     $user->email = $request->email;
    //     $user->address = $request->address;
    //     $user->phone_number = $request->phone_number;
    //     $user->gender = $request->gender;
    //     $user->save();

    //     return redirect()->back()->with('notify', 'Success change your data !');
    // }
    //move to admin

    public function requestbook()
    {
        // $book = Book::all()->paginate(6);
        $book = Book::orderBy('created_at', 'desc')->paginate(6);
        return view('transaction.request_book', ['book' => $book]);
    }

    // public function history(){

    //     return view('transaction.history', compact('req', 'borrow'));
    // }
}
