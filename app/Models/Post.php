<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Post extends Model
{

    protected $table = 'post';
        protected $fillable = [
			'user_id', 'title', 'conversation', 'billing_per_minute', 'pieces',
			 'file', 'file_type', 'status',
	];

	protected $hidden = [
		'deleted',
		'updated_at',
	];



}

