<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Book;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AuthController extends Controller
{
    //
    public function index()
    {
        if ($user = Auth::user()) {
            if ($user->role == 1) {
                return redirect()->intended('admin-dashboard');
            } elseif ($user->role == 2) {
                return redirect()->intended('dashboard');
            }
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        // if (!$cek) {
        //     return redirect('login')->with('Field null');
        // }
        $now = Carbon::now();
        if (Auth::attempt($request->only('email', 'password'))) {
            if (auth()->user()->role == 2) {
                //create log
                $user = Auth::user();
                //$logs = new Log();
                 //$logs->user_id = $user->user_id;
                //$logs->action = 'POST';
                //$logs->description = 'login system';
                //$logs->role = $user->role;
                //$logs->log_time = $now;
                //$logs->save();
                return redirect('/dashboard'); //user dashboard
            } elseif (auth()->user()->role == 1) {
                //create log
                $admn = Auth::user();
                //$logs = new Log();
                 //$logs->user_id = $admn->user_id;
                //$logs->action = 'POST';
                //$logs->description = 'login system';
                //$logs->role = $user->role;
                //$logs->log_time = $now;
                //$logs->save();
                return redirect('/admin-dashboard'); //admin dashboard
            } else {
                return redirect('/login')->with('notify', 'You don"t have role');
            }
        } else {
            return redirect('/login')->with('notify', 'Email or Password wrong');
        }
    }

    public function home()
    {
        $book = Book::orderBy('created_at', 'desc')->paginate(6);
        return view('home', compact('book'));
    }

    public function logout(Request $request)
    {
        $userAuth = Auth::user();
        $now = Carbon::now();
        // create a logs
        //$logs = new Log():
        //$logs->user_id = $userAuth->user_id;
        //$logs->action = 'POST';
        //$logs->description = 'logout';
        //$logs->log_time = $now;
        //$logs->role = $userAuth->role;
        //$logs->data_old = '';
        //$logs->data_new = '';
        //$logs->save();
        $request->session()->flush();
        Auth::logout();
        return redirect('/login')->with('notify', 'Success Logout');
    }

    public function changepassword()
    {
        return view('change_password');
    }

    public function updatepassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'reply_password' => 'required|same:password'
        ]);

        DB::table('users')->where('id_user', auth()->user()->id_user)
            ->update([
                'password' => bcrypt($request['password'])
            ]);

        // create a logs
         $now = Carbon::now();
        // create a logs
        //$logs = new Log():
        //$logs->user_id = $user->user_id;
        //$logs->action = 'POST';
        //$logs->description = 'register a new user';
        //$logs->log_time = $now;
        //$logs->data_old = '';
        //$logs->data_new = json_encode($get_last_user);
        //$logs->role = $user->role;
        //$logs->save();
        return redirect('changepassword')->with('notify', 'Success change your password');
    }

    public function create()
    {
        return view('register');
    }

    // public function store(Request $request)
    // {
    //     $validate =  $request->validate([
    //         'name' => 'required',
    //         'email' => 'required',
    //         'password' => 'required',
    //         'address' => 'required',
    //         'phone_number' => 'required|numeric',
    //         'gender' => 'required',
    //     ]);
    //     $userCheckEmail = User::where('email',$request->email)->first();

    //     User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => bcrypt($request['password']),
    //         'address' => $request->address,
    //         'phone_number' => $request->phone_number,
    //         'gender' => $request->gender,
    //         'role' => 2, //2 untuk client
    //     ]);

    //     if ($validate) {
    //         return redirect('/register')->with('notify', 'Congratulations, your account successfully created, let "enjoy !');
    //     }
    // }

    public function register(Request $request)
    {
        $validate =  $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'address' => 'required',
            'phone_number' => 'required|numeric',
            'gender' => 'required',
        ]);
        $userCheckEmail = User::where('email',$request->email)->first();
        if($userCheckEmail){
            //redirect back
            return redirect()->back()->withErrors('Email sudah digunakan')->withInput();
        }

        $userCheckPhone = User::where('phone_number', $request->phone_numbger)->first();

        if($userCheckPhone)
        {
            return redirect()->back()->withErrors('Nomor telepon sudah digunakan')->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request['password']),
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'role' => 2, //2 untuk client
        ]);

        $lastUser = $user->id;
        $get_last_user = User::find($lastUser);
        $now = Carbon::now();
        // create a logs
        //$logs = new Log():
        //$logs->user_id = $user->user_id;
        //$logs->action = 'POST';
        //$logs->description = 'register a new user';
        //$logs->log_time = $now;
        //$logs->data_old = '';
        //$logs->data_new = json_encode($get_last_user);
        //$logs->role = $user->role;
        //$logs->save();

        if($validate){
            return redirect('/register')->with('notify', 'Congratulations, your account successfully created, let "enjoy !');
        }
    }

    public function validationPhoneNumber(Request $request){
       $phone =  $request->phone_number;
       $nomerexplode = $phone;
       if(substr($nomerexplode, 0, 2) === "62"){
            $nomerparse = explode('62', $nomerexplode)[1];
            $phone = '0'.$nomerparse;

       }
    //    dd($phone);
       $checkPhoneNumberUser = User::where('phone_number', $phone)->first();
       $status = array(
         'message' => 'valid',
         'status' => true
       );

       if($checkPhoneNumberUser){
            $status = array(
                'message' => 'this number phone has been use',
                'status' => false
            );
       }

       return response()->json($status);
    }

    public function validationEmail(Request $request){
        $emai = $request->email;
        $checkEmailUser = User::where('email', $emai)->first();
        $status = array(
            'message' => 'valid',
            'status' => true,
        );

        if($checkEmailUser){
            $status = array(
                'message' => 'this email has been taken',
                'status' => false
            );
        }

        return response()->json($status);
    }
}
