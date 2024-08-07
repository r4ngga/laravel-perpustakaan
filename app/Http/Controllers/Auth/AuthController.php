<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Book;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Log;

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
                $logs = new Log();
                 $logs->user_id = $user->id_user;
                $logs->action = 'POST';
                $logs->description = 'login system';
                $logs->data_old = '-';
                $logs->data_new = '-';
                $logs->role = $user->role;
                $logs->log_time = $now;
                $logs->save();
                return redirect('/dashboard'); //user dashboard
            } elseif (auth()->user()->role == 1) {
                // dd(auth()->user()->id_user);
                //create log
                $admn = Auth::user();
                $logs = new Log();
                $logs->user_id = $admn->id_user;
                $logs->action = 'POST';
                $logs->description = 'login system';
                $logs->data_old = '-';
                $logs->data_new = '-';
                $logs->role = $admn->role;
                $logs->log_time = $now;
                $logs->save();
                return redirect('/admin-dashboard'); //admin dashboard
            } else {
                return redirect('/login')->with('error', 'You don"t have role');
            }
        } else {
            return redirect('/login')->with('error', 'Email or Password wrong');
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
        $logs = new Log();
        $logs->user_id = $userAuth->id_user;
        $logs->action = 'POST';
        $logs->description = 'logout from system';
        $logs->log_time = $now;
        $logs->role = $userAuth->role;
        $logs->data_old = '-';
        $logs->data_new = '-';
        $logs->save();
        $request->session()->flush();
        Auth::logout();
        return redirect('/login')->with('notify', 'Success Logout');
    }

    public function showSetting(){
        $user = Auth::user();
        $getUser = User::where('id_user', $user->id_user)->first();
        // dd($getUser);
        return view('setting', compact('user', 'getUser'));
    }

    public function setting(Request $request, $id)
    {
        $auth = Auth::user();
        $now = Carbon::now();
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

        if($request->photo_profile){
            $imgName = time() . '.' . $request->photo_profile->extension();
            $request->photo_profile->move(public_path('images'), $imgName);
        }

        $user = User::where('id_user', $id)->first();
        $oldImg = '';
        if($request->photo_profile){
            if($user->photo_profile)
            {
                $oldImg = '/images/'.$user->photo_profile;
                unlink(public_path($oldImg));
            }
        }

        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;
        $user->gender = $request->gender;
        if(!empty($request->photo_profile))
        {
            $user->photo_profile = $imgName;
        }
        $user->save();

        $last_insert = User::find($user->id_user);        
        //create a logs
        $logs = new Log();
        $logs->id_user = $auth->id_user;
        $logs->action = 'PUT';
        $logs->description = 'update setting a profile';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = json_encode($lastUser);
        $logs->data_new = json_encode($last_insert);
        $logs->save();

        return response()->json(['notify' => 'success', 'data' => 'Your Profile successfully change !']);
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

        $get_last_user = DB::table('users')->where('id_user', auth()->user()->id_user)
            ->update([
                'password' => bcrypt($request['password'])
            ]);

        $user = Auth::user();

        // create a logs
         $now = Carbon::now();
        // create a logs
        $logs = new Log();
        $logs->user_id = $user->id_user;
        $logs->action = 'PUT';
        $logs->description = 'update a password';
        $logs->log_time = $now;
        $logs->data_old = '';
        $logs->data_new = json_encode($get_last_user);
        $logs->role = $user->role;
        $logs->save();
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
        $logs = new Log();
        $logs->user_id = $user->id_user;
        $logs->action = 'POST';
        $logs->description = 'register a new user';
        $logs->log_time = $now;
        $logs->data_old = '-';
        $logs->data_new = json_encode($get_last_user);
        $logs->role = $user->role;
        $logs->save();

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
