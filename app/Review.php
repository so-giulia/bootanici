<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    protected $fillable =[
        'user_id',
        'name',
        'feedback_text',
        'vote'
      ];
      public function users(){
        return $this->belongsTo('App\User');
      }
}
