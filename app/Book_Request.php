<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book_Request extends Model
{
    protected $table = 'book_requests';
    protected $guard = [];
    protected $fillable = ['id_user', 'id_book', 'time_request', 'status_request']; 

    public function book()
    {
        return $this->hasMany(Book::class, 'id_book', 'code_borrow');
    }

    // public function user()
    // {
    //    return $this->belongsTo(User::class, 'id_user', 'id_user');
    // }
}
