<?php 

namespace App\Http\Controllers\Api;

use App\Book;
use App\Book_Borrow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class BookApiController extends Controller
{
    public function getBooks()
    {
        $books = Book::all();
        $books = Book::orderBy('created_at', 'desc')->get();

        $countbooks = count($books);

        if($countbooks > 0){
            foreach($books as $bk)
            {
                $book = array(
                    'id_book' => $bk->id_book,
                    'name_book' => $bk->name_book,
                    'author' => $bk->author,
                    'publisher' => $bk->publisher,
                    'time_release' => $bk->time_release,
                    'pages_book' => $bk->pages_book,
                    'language' => $bk->language,
                    'isbn' => $bk->isbn,
                    'image' => '',
                );
            }

            $data = array(
                'status' => true,
                'code' => 200,
                'message' => 'success',
                'counts' => $countbooks,
                'data' => $book,
            );
        }else{
            $data = array(
                'status' => true,
                'code' => 404,
                'message' => 'fail',
                'counts' => 0,
            );
        }

        return response()->json($data);
    }

    public function fetchGetBooks($id)
    {
        $book = Book::where('id_book', $id)->first();

        $countbook = count($book);

        if($countbook > 0)
        {
            foreach($book as $bk)
            {
                $bks = array(
                    'id_book' => $bk->id_book,
                    'name_book' => $bk->name_book,
                    'author' => $bk->author,
                    'publisher' => $bk->publisher,
                    'time_release' => $bk->time_release,
                    'pages_book' => $bk->pages_book,
                    'language' => $bk->language,
                    'isbn' => $bk->isbn,
                    'image' => '',
                );

                $data = array(
                    'status' => true,
                    'code' => 200,
                    'message' => 'success, show data id_book',
                    'counts' => $countbook,
                    'data' => $bks,
                );
            }
        }else{
            $data = array(
                'status' => false,
                'code' => 404,
                'message' => 'fail',
                'counts' => 0
            );
        }

        return response()->json($data);
    }

    public function fetchBySearch(Request $request)
    {
        $inpt_req = $request->search;

        $books = Book::where('id_book', $inpt_req)
                      ->orWhere('name_book', 'LIKE', '%'.$inpt_req.'%')
                      ->orWhere('author', 'LIKE', '%'.$inpt_req.'%')
                      ->orWhere('publisher', 'LIKE', '%'.$inpt_req.'%')
                      ->orWhere('time_release', 'LIKE', '%'.$inpt_req.'%')
                      ->orWhere('language', 'LIKE', '%'.$inpt_req.'%')
                      ->get();
        
        $countsearch = count($books);
        if($countsearch > 0){
            foreach($books as $bk)
            {
                $data = array(
                    'id_book' => $bk->id_book,
                    'name_book' => $bk->name_book,
                    'author' => $bk->author,
                    'publisher' => $bk->publisher,
                    'time_release' => $bk->time_release,
                    'pages_book' => $bk->pages_book,
                    'language' => $bk->language,
                    'isbn' => $bk->isbn,
                    'image' => '',
                );
            }

            $book = array(
                'status' => true,
                'code' => 200,
                'message' => 'success search by input',
                'counts' => $countsearch,                                                                                                                                                                                                                                                                                                                                                                  
                'data' => $data,
            );
        }else{
            $book = array(
                'status' => false,
                'code' => 404,
                'message' => 'failed search a books',
                'counts' => 0,
            );
        }
        // dd($books);

        return response()->json($book);
        
    }
}
