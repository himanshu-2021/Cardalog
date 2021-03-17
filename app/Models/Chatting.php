<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chatting extends Model
{
        protected $fillable = [
            'chat_id','from_user_id','to','message',
            'chat_type','media_id'
        ];
        protected $hidden = [
            'updated_at',
        ];
}
