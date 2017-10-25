<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'firstName', 'lastName'
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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['stock_investment', 'net_value'];
    
    public function hasEnoughCash($purchase) {}
    
    public function stocks() 
    {
        return $this->belongsToMany('App\Stock')->withTimestamps()->withPivot('purchased_price', 'quantity', 'id');
    }

    public function getStockInvestmentAttribute() 
    {
        $sum = 0; 
        foreach($this->stocks as $stock) {
            $sum += ($stock->pivot->quantity * $stock->current_price);
        }
        
        return $sum;
    }
    
    public function getNetValueAttribute() 
    {
        return $this->stock_investment + $this->cash; 
    }
}
