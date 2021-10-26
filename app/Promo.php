<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $table = 'promos';
    protected $fillable =[
        'name',
        'duration',
        'price',
      ];
      public function promoUsers(){
        return $this->hasMany('App\PromoUser');
      }

}
