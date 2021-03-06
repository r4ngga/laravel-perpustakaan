<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Book extends Model
{
    protected $primaryKey = 'id_book';
    protected $fillable = [
        'isbn', 'name_book', 'author', 'publisher', 'time_release', 'pages_book', 'language', 'image_book'
    ];
    //
}
