<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable =[
        'user_id',
        'from_email',
        'name_guest',
        'object_email',
        'message'
        
      ];

      public function users(){
        return $this->belongsTo('App\User');
      }
}
