<?php

namespace App;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'first_name', 'last_name', 'email', 'phone', 'password', 'company', 'address1', 'address2', 'province_id', 'city_id', 'postcode,','role_id',
	];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function pesanan()
    {
        return $this->hasMany(Penjualan::class, 'user_id' ,'id');
    }
    public function favorites()
	{
		return $this->hasMany('App\Favorite');
	}
}
