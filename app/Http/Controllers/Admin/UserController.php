<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Http\Controllers\Controller;
use App\Book;
use App\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('user.index');
        $users = User::where('role', 2)->get();
        $countUser = User::where('role', 2)->get()->count();
        // dd($countUser->count());
        // return view('user.show_all', compact('users', 'countUser'));
        return view('admin.users.index', compact('users', 'countUser'));
    }

    public function requestbook()
    {
        // $book = Book::all()->paginate(6);
        $book = Book::orderBy('created_at', 'desc')->paginate(6);
        return view('transaction.request_book', ['book' => $book]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate =  $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone_number' => 'required|numeric',
            'gender' => 'required',
        ]);

        $user = User::where('id_user', $request->id_user)->get();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = !empty($request->password) ?  bcrypt($request['password']) : null;
        $user->address = $request->address;
        $user->phone_number = $request->phone_number;
        $user->gender = $request->gender;
        $user->role = 2; //untuk client atau user
        $user->save();

        $auth = Auth::user();
        $now = Carbon::now();

        //create a logs
        $logs = new Log();
        $logs->name = $request->name;
        $logs->user_id = $auth->user_id;
        $logs->action = 'POST';
        $logs->description = 'add a new user';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = '-';
        $logs->data_new = json_encode($user);
        $logs->save();

        if ($validate) {
            return redirect('/users')->with('notify', 'Data a new user successfully insert !!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('user.show_all', ['user' => $user]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();
        return view('setting', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $auth = Auth::user();
        $now = Carbon::now();
        // $lastUser = User::findOrFail($request->id_user);
        $lastUser = DB::table('users')->where('id_user', $id)->first();
        $lastUserPassword = $lastUser->password;
        $request->validate([
            'id_user' => 'required',
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone_number' => 'required|numeric',
            'gender' => 'required',
        ]);

        $user = User::where('id_user', $request->id_user)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone_number = $request->phone_number;
        $user->gender = $request->gender;
        $user->password = !empty($request->password) ? bcrypt($request['password']) : $lastUserPassword;
        $user->save();

        //create a logs
        $logs = new Log();
        $logs->user_id = $auth->id_user;
        $logs->action = 'PUT';
        $logs->description = 'update a user';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = json_encode($lastUser);
        $logs->data_new = json_encode($user);
        $logs->save();

        return redirect()->back()->with('notify', 'Success Change data user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        $auth = Auth::user();
        $now = Carbon::now();
        $cekvalidation = $request->validation;
        if ("delete" == $cekvalidation || "Delete" == $cekvalidation) {
            $lastUser = User::where('id_user', $user->id_user)->first();
            //create a logs
            $logs = new Log();
            $logs->user_id = $auth->id_user;
            $logs->action = 'PUT';
            $logs->description = 'update a user';
            $logs->role = $auth->role;
            $logs->log_time = $now;
            $logs->data_old = json_encode($lastUser);
            $logs->data_new = '';
            $logs->save();

            User::destroy($user->id_user);
            return redirect('/user')->with('notify', 'Data account user successfully delete !');
        } else {
            return redirect('/user')->with('notify', 'Failed delete data account user');
        }
    }

    public function fetchShow($id){
        $user = User::findOrFail($id);

        if($user->role == 2){
            $role = 'client';
        }else{
            $role = 'admin';
        }

        $data = array(
            'id' => $user->id_user,
            'name' => $user->name,
            'email' => $user->email,
            'address' => $user->address,
            'phone_number' => $user->phone_number,
            'gender' => $user->gender,
            'role' => $role,
            'created_at' => $user->created_at,
        );
        return response()->json($data);
    }

    public function fetchEdit($id){
        $user = User::where('id_user', $id)->where('role', 2)->first();

        return response()->json($user);
    }

}
