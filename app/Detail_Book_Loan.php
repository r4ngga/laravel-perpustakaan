<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail_Book_Loan extends Model
{
    protected $primaryKey = 'number_borrow';
    protected $fillable = [
        'code_borrow', 'id_book', 'qty'
    ];

    protected $table = 'detail_book_loans';

    public function book()
    {
        return $this->hasMany(Book::class, 'id_book', 'number_borrow');
    }
}
