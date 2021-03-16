<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'group_id','user_id','group_name','group_icon','group_delete',
        'master',
    ];
    protected $hidden = [
        'updated_at','deleted_at'
    ];
}
