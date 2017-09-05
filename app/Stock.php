<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    //
    protected $fillable = [
        'name', 'symbol', 'source'
    ];
    public function users() 
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
}
