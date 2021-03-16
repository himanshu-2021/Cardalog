<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Country extends Model
{

    protected $table = 'country';
        protected $fillable = [
            'shortcode_two','country','country_nicename','shortcode_three',
            'number_code','phone_code',
	];

	protected $hidden = [
		'deleted',
		'updated_at',
	];



}

