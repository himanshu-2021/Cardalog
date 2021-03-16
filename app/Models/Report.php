<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Report extends Model
{

    protected $table = 'report';
        protected $fillable = [
			 'from_user_id', 'post_id', 'description',
	];

	protected $hidden = [
		'deleted',
		'updated_at',
	];



}

