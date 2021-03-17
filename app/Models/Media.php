<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'medias';
    protected $fillable = [
        'chat_id','path','file_type','deleted_by'
    ];
    protected $hidden = [
        'updated_at','deleted_at'
    ];
}
