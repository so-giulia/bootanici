<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class PromoUser extends Model
{
    protected $fillable =[
        'promo_id',
        'user_id',
        'start',
        'end'
    ];
    protected $table = 'promo_user';
    public function users(){
        return $this->belongsTo('App\User');
    }
    public function promos(){
        return $this->belongsTo('App\Promo');
      }
}
