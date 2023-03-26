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
            // 'image_book' => 'mimes:jpeg,png,jpg,gif,svg',
        ]);
        if($request->image_book)
        {
            $imgName = $request->image_book->getClientOriginalName() . '-' . time() . '.' . $request->image_book->extension();
            $request->image_book->move(public_path('images'), $imgName);
        }

        if ($request->isbn == null) {
            $request->isbn = '-';
        }

        $book = new Book();
        $book->name_book = $request->name_book;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->time_release = $request->time_release;
        $book->pages_book = $request->pages_book;
        $book->language =  $request->language;
        $book->isbn = $request->isbn;
        $book->image_book = !empty($request->image_book) ? $imgName : null;
        $book->save();
        // Book::create([
        //     'name_book' => $request->name_book,
        //     'author' => $request->author,
        //     'publisher' => $request->publisher,
        //     'time_release' => $request->time_release,
        //     'pages_book' => $request->pages_book,
        //     'language' => $request->language,
        //     'image_book' => $imgName,
        //     'isbn' =>  $request->isbn,
        // ]);
    return redirect('/book')->with('notify', 'Data a new book successfully insert !');
    }

    public function show($id)
    {
        $book = Book::findOrfaill($id);

        return json_decode($book, true);
    }

    public function edit($id)
    {
        return view('book.change_book');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_book' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'time_release' => 'required|numeric',
            'pages_book' => 'required|numeric',
            'language' => 'required',
            // 'image_book' => 'mimes:jpeg,png,jpg,gif,svg',
        ]);

        if($request->image_book){
            $imgName = $request->image_book->getClientOriginalName() . '-' . time() . '.' . $request->image_book->extension();
            $request->image_book->move(public_path('images'), $imgName);
        }

        if($request->isbn == null){
            $request->isbn = '-';
        }

        Book::where('id', $id)->update([
            'name_book' => $request->name_book,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'time_release' => $request->time_release,
            'pages_book' => $request->pages_book,
            'language' => $request->language,
            'image_book' => $imgName,
            'isbn' =>  $request->isbn,
        ]);

        return redirect()->back()->with('notify', 'Data a book successfully change !');
    }

    public function destroy($id)
    {
       $delete_book = Book::findOrFaill($id);
       $delete_book->destroy();

       return redirect('/book')->with('notify', 'Data a book successfully delete !');
    }

    public function confirmDelete(Request $request, $id)
    {
        $cekpassword = $request->validation;
        if ("delete" == $cekpassword || "Delete" == $cekpassword) {
            Book::destroy($id);
            return redirect('/book')->with('notify', 'Data a book successfully delete !');
        } else {
            return redirect('/book')->with('notify', 'Failed delete data a book');
        }
    }
}
