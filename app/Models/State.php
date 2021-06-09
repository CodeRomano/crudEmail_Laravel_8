<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $table = 'states';

    public function country()
    {
        return $this->belongsTo('App\Country');
    }
    
    public function city()
    {
        return $this->hasMany('App\City');
    }

}
