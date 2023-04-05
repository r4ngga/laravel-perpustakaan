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

    public function fetchIndex(){
        $books = Book::all();
        $html = '';
        foreach($books as $book){
            $html .= '<tr>';
            $html .= '<td>'.$book->id_book ?? ''.'</td>';
            $html .= '<td>'.$book->isbn ?? '-' .'</td>';
            $html .= '<td>'.$book->name_book ?? ''.'</td>';
            $html .= '<td>'.$book->author ?? '' .'</td>';
            $html .= '<td>'.$book->publisher ?? '' .'</td>';
            $html .= '<td>'.$book->time_release ?? '' .'</td>';
            $html .= '<td>'.$book->pages_book ?? '' .'</td>';
            $html .= '<td>'.$book->language ?? '' .'</td>';
            $html .= '<td>'; //act
                $html .= '<a onclick="getEdtBook( '.$book->id_book.','.$book->name_book .', '. $book->isbn .','.$book->author.','.$book->publisher.', '.$book->time_release.','.$book->pages_book.','.$book->language.')" data-toggle="modal" data-target="#editbook" class="btn btn-sm btn-info">';
                $html .= '<svg class="svg-inline--fa fa-pen-to-square" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pen-to-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">';
                $html .= '<path fill="currentColor" d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.8 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"></path>';
                // $html .= '<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>';
                $html .= '</svg> </a>';

                $html .= '<a href="'.$book->id_book.'/#ComfirmDeleteModal" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ComfirmDeleteModal'.$book->id_book.'">';
                $html .= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">';
                $html .= '<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>';
                $html .= '<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>';
                $html .= '</svg> </a>';

                $html .= '<a href="#" class="btn btn-sm btn-warning">Show a Detail</a>';
            $html .= '</td>';
            $html .= '</tr>';
        }
        // return response()->json($books);
        return response()->json(['html' => $html]);
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
        $book = Book::findOrfail($id);

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

        $book = Book::where('id_book', $id)->first();
        $book->name_book = $request->name_book;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->time_release = $request->time_release;
        $book->pages_book = $request->pages_book;
        $book->language = $request->language;
        $book->isbn = $request->isbn;
        $book->image_book = !empty($request->image_book) ? $imgName : null;
        $book->save();

        // Book::where('id', $id)->update([
        //     'name_book' => $request->name_book,
        //     'author' => $request->author,
        //     'publisher' => $request->publisher,
        //     'time_release' => $request->time_release,
        //     'pages_book' => $request->pages_book,
        //     'language' => $request->language,
        //     'image_book' => $imgName,
        //     'isbn' =>  $request->isbn,
        // ]);

        // return redirect('/book')->with('notify', 'Data a book successfully change !');
        //return redirect()->back()->with(['notify' => 'Data a book successfully change !']);

        return response()->json(['notify' => 'success', 'data' => 'Data a book successfully change !']);
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
