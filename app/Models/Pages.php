<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Pages extends Model
{
    protected $table = 'pages';
    protected $fillable = [
        'about_us', 'terms_conditions', 'privacy_policy', 'location_service_policy',
];

protected $hidden = [
    'deleted',
    'updated_at',
];

}
