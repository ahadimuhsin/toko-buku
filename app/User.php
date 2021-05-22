<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Order;

class User extends Authenticatable
{
    use Notifiable;

    // protected $primaryKey = "id_user";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'roles', 'address',
        'city_id', 'province_id', 'phone', 'avatar', 'status', 'api_token'
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

    //relationship dengan orders
    //setiap user bisa memiliki banyak order
    //ini yg one
    public function orders(){
        return $this->hasMany(Order::class);
    }
}
