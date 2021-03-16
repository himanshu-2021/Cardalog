<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Users extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'avatar', 'name', 'nick_name','social_type','phone_code', 'mobile', 'gender', 'dob','country', 'email', 'email_verified_at', 'password', 'package_id', 'terms_conditions', 'privacy_policy', 'location_service_policy', 'device_id', 'contact_details', 'role', 'account_status', 'login_status', 'is_deleted',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

   /* public function Post()
    {
        return $this->hasMany(Post::class);
    }*/

}
