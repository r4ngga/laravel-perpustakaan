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
        return view('user.index');
    }

    public function edit(){
        return view('setting');

    }

    public function fetchEdit($id){
        $users = User::findOrfail($id);
        $json_encode = json_encode($users);

        return $json_encode;
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'required',
            'password' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'gender' => 'required',
        ]);

        $user = User::where('id_user', auth()->user()->id_user)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone_number = $request->phone_number;
        $user->gender = $request->gender;
        $user->save();

        return redirect()->back()->with('notify', 'Success change your data !');
    }
}
