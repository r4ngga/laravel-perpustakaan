<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Book;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('book.index', compact('books'));
    }

    public function create()
    {
        return view('book.add_book');
    }

    public function store(Request $request)
    {
        // $validate = '';
        $validateData = $request->validate([
            'name_book' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'time_release' => 'required|numeric',
            'pages_book' => 'required|numeric',
            'language' => 'required',
            'image_book' => 'mimes:jpeg,png,jpg,gif,svg',
        ]);
        $imgName = $request->image_book->getClientOriginalName() . '-' . time() . '.' . $request->image_book->extension();
        $request->image_book->move(public_path('images'), $imgName);
        if ($request->isbn == null) {
            $request->isbn = '-';
        }

        Book::create([
            'name_book' => $request->name_book,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'time_release' => $request->time_release,
            'pages_book' => $request->pages_book,
            'language' => $request->language,
            'image_book' => $imgName,
            'isbn' =>  $request->isbn,
        ]);
    return redirect('/book')->with('notify', 'Data a new book successfully insert !');
    }

    public function edit($id)
    {
        return view('book.change_book');
    }

    public function update(Request $request, $id)
    {

    }
}
