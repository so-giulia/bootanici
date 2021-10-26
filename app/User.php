<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'slug',
        'email',
        'password',
        'address',
        'cap'
    ];


    public function user_details()
    {
        return $this->hasOne('App\UserDetail');
    }

    public function specializations() {
        return $this->belongsToMany('App\Specialization');
    }

    public function portfolios(){
      return $this->hasMany('App\Portfolio');
    }
    public function reviews(){
      return $this->hasMany('App\Review');
    }
    public function leads(){
      return $this->hasMany('App\Lead');
    }
    public function promoUsers(){
      return $this->hasMany('App\PromoUser');
    }
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
}
