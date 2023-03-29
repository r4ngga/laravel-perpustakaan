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

    public function update(){

    }
}
