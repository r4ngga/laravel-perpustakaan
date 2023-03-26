<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Http\Controllers\Controller;
use App\Book;
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
        return view('user.show_all', compact('users'));
    }

    public function requestbook()
    {
        // $book = Book::all()->paginate(6);
        $book = Book::orderBy('created_at', 'desc')->paginate(6);
        return view('transaction.request_book', ['book' => $book]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('register');
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

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = !empty($request->password) ?  bcrypt($request['password']) : null;
        $user->address = $request->address;
        $user->phone_number = $request->phone_number;
        $user->gender = $request->gender;
        $user->role = 2; //untuk client atau user
        $user->save();

        // User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => bcrypt($request['password']),
        //     'address' => $request->address,
        //     'phone_number' => $request->phone_number,
        //     'gender' => $request->gender,
        //     'role' => 2, //2 untuk client
        // ]);

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
    public function show()
    {
        $user = User::all();
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
        return view('setting');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'id_user' => 'required',
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone_number' => 'required|numeric',
            'gender' => 'required',
        ]);

        User::where('id_user', auth()->user()->id_user)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
            ]);

        return redirect('/setting')->with('notify', 'Success Change your data account');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        $cekvalidation = $request->validation;
        if ("delete" == $cekvalidation || "Delete" == $cekvalidation) {
            User::destroy($user->id_user);
            return redirect('/user')->with('notify', 'Data account user successfully delete !');
        } else {
            return redirect('/user')->with('notify', 'Failed delete data account user');
        }
    }

    public function history()
    {
        $req = DB::table('book_requests')
            ->join('users', 'book_requests.id_user', '=', 'users.id_user')
            ->join('books', 'book_requests.id_book', '=', 'books.id_book')
            ->select('book_requests.*', 'users.*', 'books.*')
            ->where('book_requests.id_user', auth()->user()->id_user)
            ->orderBy('book_requests.time_request')
            ->orderBy('book_requests.id_user')
            ->get();

        $borrow = DB::table('book_borrows')
            ->join('detail_book_loans', 'book_borrows.code_borrow', '=', 'detail_book_loans.code_borrow')
            ->join('users', 'book_borrows.id_user', '=', 'users.id_user')
            ->join('books', 'detail_book_loans.id_book', '=', 'books.id_book')
            ->select('book_borrows.*', 'detail_book_loans.*', 'users.*', 'books.*')
            ->where('book_borrows.id_user', auth()->user()->id_user)
            ->orderBy('book_borrows.time_borrow')
            ->orderBy('detail_book_loans.number_borrow')
            ->get();

        return view('transaction.history', compact('req', 'borrow'));
    }
}
