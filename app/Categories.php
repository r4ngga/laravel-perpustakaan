<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Categories extends Model
{
    protected $table = 'categories';

    public function book()
    {
        return $this->hasMany(Book::class, 'id');
    }
}