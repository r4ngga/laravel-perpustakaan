<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book_Return extends Model
{
    // protected $primaryKey = 'code_return';
    protected $fillable = [
        'id_user', 'time_return', 'code_borrow'
    ];
}
