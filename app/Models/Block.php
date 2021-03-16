<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Block extends Model
{

    protected $table = 'user_block';
        protected $fillable = [
			'user_id', 'block_user_id', 'description', 'status','reason_for_block', 
	];

	protected $hidden = [
		'deleted',
		'updated_at',
	];



}

