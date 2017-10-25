<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Custom\Quandl\QuandlApi;

class Stock extends Model
{
    //
    protected $fillable = [
        'name', 'symbol', 'source'
    ];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['current_data'];
    
    public function users() 
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
    
    /**
     * Get the current price of the stock.
     *
     * @return Float
     */
    public function getCurrentDataAttribute() 
    {
        $quandlAPI = new QuandlAPI(); 
        $stockFromQuandlAPI = $quandlAPI->getStock($this->symbol);
    
        return $stockFromQuandlAPI;
    }
    
}
