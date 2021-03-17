<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diamond extends Model
{
    protected $fillable = [
      'status','diamonds_qty' ,'diamonds_images', 'type','sender_id','reciever_id','transection_id'
    ];
    protected $hidden = [
        'updated_at','deleted_at'
    ];
}
