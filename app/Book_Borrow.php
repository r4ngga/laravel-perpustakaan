<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book_Borrow extends Model
{
    protected $table = 'book_borrows';
    protected $primaryKey = 'code_borrow';
    protected $fillable = [
        'id_user', 'time_borrow', 'id_book'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

}
