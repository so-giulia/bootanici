<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
        'user_id',
        'propic_url',
        'bio',
        'service',
        'phone',
        'avg_hourly_rate'
    ];
    // add chiave primaria 
    protected $primaryKey = 'user_id';
    
    public function users()
    {
        return $this->belongsTo('App\User');
    }
}
