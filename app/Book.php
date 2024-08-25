<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Book extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'id_book';
    protected $fillable = [
        'isbn', 'name_book', 'author', 'publisher', 'time_release', 'pages_book', 'language', 'image_book'
    ];
    //

    public function detailbookloan()
    {
        return $this->belongsTo(Detail_Book_Loan::class, 'id_book', 'id_book');
    }

    public function categories()
    {
        return $this->belongsToMany(Categories::class, 'categori_id', 'id');
    }
}
