<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail_Book_Enter extends Model
{
    protected $primaryKey = 'number_return';
    protected $fillable = [
        'code_return', 'id_book', 'qty_return'
    ];
}
