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

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    } //user_id -> id user in logs, id_user -> id user in tb users
}
