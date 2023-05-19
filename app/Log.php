<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';
    protected $fillable = [
       'user_id', 'action', 'description', 'role', 'log_time', 'data_old', 'data_new'
       //, 'description'
    ];

}
