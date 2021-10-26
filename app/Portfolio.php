<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable =[
      'user_id',
      'image_url'
    ];
    public function users(){
      return $this->belongsTo('App\User');
    }
    protected $table = 'portfolio_images';
}
