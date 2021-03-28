<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Book;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $book = Book::all();
        return view('book.index', ['book' => $book]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('book.add_book');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name_book' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'time_release' => 'required|numeric',
            'pages_book' => 'required|numeric',
        ]);
        Book::create($request->all());
        return redirect('/book')->with('notify', 'Data a new book successfully insert !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        return view('book.change_book', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'name_book' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'time_release' => 'required|numeric',
            'pages_book' => 'required|numeric',
        ]);
        Book::where('id_book', $book->id_book)
            ->update([
                'name_book' => $request->name_book,
                'author' => $request->author,
                'publisher' => $request->publisher,
                'time_release' => $request->time_release,
                'pages_book' => $request->pages_book,
            ]);
        return redirect('/book')->with('notify', 'Data a book successfully change !');
    }

    public function confirmdelete(Request $request, Book $book)
    {
        // $validate =  $request->validate([
        //     'password' => 'required',
        // ]);
        $cekpassword = $request->validation;
        if ("delete" == $cekpassword || "Delete" == $cekpassword) {
            Book::destroy($book->id_book);
            return redirect('/book')->with('notify', 'Data a book successfully delete !');
        } else {
            return redirect('/book')->with('notify', 'Failed delete data a book');
        }
    }
    // {{auth()->user()->name}}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        Book::destroy($book->id_book);
        return redirect('/book')->with('notify', 'Data a book successfully delete !');
    }
}
