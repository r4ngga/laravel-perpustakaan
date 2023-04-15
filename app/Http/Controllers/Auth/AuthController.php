<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Book;
use App\Http\Controllers\Controller;

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
        if (Auth::attempt($request->only('email', 'password'))) {
            if (auth()->user()->role == 2) {
                return redirect('/dashboard'); //user dashboard
            } elseif (auth()->user()->role == 1) {
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

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request['password']),
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'role' => 2, //2 untuk client
        ]);

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
