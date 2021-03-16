<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Otp extends Model
{

    protected $table = 'otp';
        protected $fillable = [
             'user_id', 'otp', 'expire', 'auth_type', 'status',
	];

	protected $hidden = [
		'deleted',
		'updated_at',
	];



}

