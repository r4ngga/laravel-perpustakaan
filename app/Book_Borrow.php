<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book_Borrow extends Model
{
    protected $primaryKey = 'code_borrow';
    protected $fillable = [
        'id_user', 'time_borrow', 'id_book'
    ];
}
