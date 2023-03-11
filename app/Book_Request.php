<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book_Request extends Model
{
    protected $table = 'book_requests';
    protected $guard = [];

    public function book()
    {
        return $this->hasMany(Book::class, 'id_book', 'code_borrow');
    }
}
