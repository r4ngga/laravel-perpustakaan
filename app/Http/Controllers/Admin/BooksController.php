<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Book;
use App\Log;
use Carbon\Carbon;
use File;
use Illuminate\Support\Facades\Auth;


class BooksController extends Controller
{
    public function index()
    {
        $books = Book::all();
        $countBook = Book::count();
        // dd($countBook);
        return view('admin.book.index', compact('books', 'countBook'));
    }

    public function fetchIndex(){
        $books = Book::all();
        $default_jpeg = 'default.jpeg';
        $html = '';
        foreach($books as $book){
            $img_book = $book->image_book ?? 'default.jpeg';
            $html .= '<tr>';
            $html .= '<td>'.$book->id_book ?? ''.'</td>';
            $html .= '<td>'.$book->isbn ?? '-' .'</td>';
            $html .= '<td>'.$book->name_book ?? ''.'</td>';
            $html .= '<td>'.$book->author ?? '' .'</td>';
            $html .= '<td>'.$book->publisher ?? '' .'</td>';
            $html .= '<td>'; //act
                $html .= '<a onclick="fetchEdit( `'.$book->id_book.'` )" data-toggle="modal" data-target="#editbook" class="btn btn-sm btn-info mr-1">';
                $html .= '<svg class="svg-inline--fa fa-pen-to-square" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pen-to-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">';
                $html .= '<path fill="currentColor" d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.8 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"></path>';
                // $html .= '<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>';
                $html .= '</svg> </a>';

                $html .= '<a href="'.$book->id_book.'/#ComfirmDeleteModal" class="btn btn-sm btn-danger mr-1" data-toggle="modal" data-target="#ComfirmDeleteModal'.$book->id_book.'">';
                $html .= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">';
                $html .= '<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>';
                $html .= '<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>';
                $html .= '</svg> </a>';

                $html .= '<a onclick="fetchShowBook('.$book->id_book.')" data-toggle="modal" data-target="#showbook" class="btn btn-sm btn-warning mr-1">';
                $html .= '<svg class="svg-inline--fa fa-eye" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="eye" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">';
                $html .= '<path fill="currentColor" d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path>';
                $html .= '</svg>';
                $html .= '</a>';
            $html .= '</td>';
            $html .= '</tr>';
        }
        // return response()->json($books);
        return response()->json(['html' => $html]);
    }

    public function fetchEdit($id)
    {
        $book = Book::findOrFail($id);
        if($book->image_book){
        $image_book = '/images/'.$book->image_book;
        }else{
            $image_book = '/images/default.jpeg';
        }
        // $data = ;
        return response()->json( array(
            'id_book' => $book->id_book,
            'isbn' => $book->isbn,
            'name_book' => $book->name_book,
            'author' => $book->author,
            'publisher' => $book->publisher,
            'time_release' => $book->time_release,
            'pages_book' => $book->pages_book,
            'language' => $book->language,
            'stok' => $book->stok,
            'image_book' => $image_book
        ));
    }

    public function create()
    {
        $categories = DB::table('categories')->get();
        return view('admin.book.add_book', compact('categories'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
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

        $user = Auth::user();
        $now = Carbon::now();

        $book = new Book();
        $book->name_book = $request->name_book;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->time_release = $request->time_release;
        $book->pages_book = $request->pages_book;
        $book->language =  $request->language;
        $book->isbn = $request->isbn;
        $book->stok = $request->stok;
        $book->category_id = $request->category_id;
        $book->image_book = !empty($request->image_book) ? $imgName : null;
        $book->save();

        $last_book = Book::find($book->id_book);

        //create log
        $logs = new Log();
        $logs->user_id = $user->id_user;
        $logs->action = 'POST';
        $logs->description = 'add a new book';
        $logs->role = $user->role;
        $logs->log_time = $now;
        $logs->data_old = '-';
        $logs->data_new = json_encode($last_book) ;
        $logs->save();
        // $data_ma_items = MaintenanceItem::find($ma_items->id);
        // //audittrails
        // Helper::doAuditTrails(Auth::user()->id, "create maintenance items", "-", json_encode($data_ma_items));

        $logs->save();

    return redirect()->back()->with('notify', 'Data a new book successfully insert !');
    }

    public function show($id)
    {
        $book = Book::findOrfail($id);

        return json_decode($book, true);
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('admin.book.change_book', compact('book'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'name_book' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'time_release' => 'required|numeric',
            'pages_book' => 'required|numeric',
            'language' => 'required',
            // 'image_book' => 'mimes:jpeg,png,jpg,gif,svg',
        ]);

        $old_book = Book::where('id_book', $id)->first();

        if($request->image_book){
            // $imgName = $request->image_book->getClientOriginalName() . '-' . time() . '.' . $request->image_book->extension();
            $setoriname = $request->image_book->getClientOriginalName() ;
            $imgName =  time() . '.' . $request->image_book->extension();
            $request->image_book->move(public_path('images'), $imgName);
        }

        if($request->isbn == null){
            $request->isbn = '-';
        }

        // $old_book = Book::where('id_book', $id)->first();
        $book = Book::where('id_book', $id)->first();
        $oldImg = '';
        if($request->image_book){
            if($book->image_book){
                $oldImg = '/images/'.$book->image_book;
                unlink(public_path($oldImg));
            }
        }        
        // dd($oldImg);

        $book->name_book = $request->name_book;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->time_release = $request->time_release;
        $book->pages_book = $request->pages_book;
        $book->language = $request->language;
        $book->stok = $request->stok;
        $book->isbn = $request->isbn;
        $book->category_id = $request->category_id;
        if(!empty($request->image_book))
        {
            $book->image_book = $imgName;
        }

        $book->save();

        //return redirect()->back()->with(['notify' => 'Data a book successfully change !']);
        $last_book = Book::find($book->id_book);
        $user = Auth::user();
        $now = Carbon::now();
        $logs = new Log();
         $logs->user_id = $user->id_user;
        $logs->action = 'PUT';
        $logs->description = 'update a book';
        $logs->role = $user->role;
        $logs->log_time = $now;
        $logs->data_old = json_encode($old_book);
        $logs->data_new = json_encode($last_book);
        $logs->save();

        return response()->json(['notify' => 'success', 'data' => 'Data a book successfully change !']);
    }

    public function destroy($id)
    {
        $old_book = Book::find($id);
       $delete_book = Book::findOrFaill($id);
       $delete_book->destroy();

       $user = Auth::user();
       $now = Carbon::now();

       //create log delete book

       $logs = new Log();
        $logs->user_id = $user->user_id;
        $logs->action = `DELETE`;
        $logs->description = 'delete a book';
        $logs->role = $user->role;
        $logs->log_time = $now;
        $logs->data_old = json_encode($old_book);
        $logs->data_new = '-';
        $logs->save();

    //    return redirect('/book')->with('notify', 'Data a book successfully delete !');
       return redirect()->back()->with('notify', 'Data a book successfully delete !');
    }

    public function confirmDelete(Request $request, $id)
    {
        $cekpassword = $request->validation;
        if ("delete" == $cekpassword || "Delete" == $cekpassword) {
            $old_book = Book::find($id);
            Book::destroy($id);
            $user = Auth::user();
            $now = Carbon::now();

            //create log delete book

             $logs = new Log();
             $logs->user_id = $user->user_id;
             $logs->action = `DELETE`;
             $logs->description = 'delete a book';
             $logs->role = $user->role;
             $logs->log_time = $now;
             $logs->data_old = json_encode($old_book);
             $logs->data_new = '-';
             $logs->save();
             
            // return redirect('/book')->with('notify', 'Data a book successfully delete !');
            return redirect()->back()->with('notify', 'Data a book successfully delete !');
        } else {
            return redirect()->back()->with('notify', 'Failed delete data a book');
        }
    }
}
