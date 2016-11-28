<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ["user_id", "sender_id", "subject", "message"];

    public function sender()
    {
        return $this->hasOne('App\User', 'id', 'sender_id');
    }
}
