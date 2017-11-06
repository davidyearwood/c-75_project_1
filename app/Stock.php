<?php

namespace App;

use GuzzleHttp\Client;
use App\HttpClient\QuandlClient;
use Illuminate\Database\Eloquent\Model;

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
        $quandlAPI = new QuandlClient(new Client()); 
        $stockFromQuandlAPI = $quandlAPI->getStock($this->symbol);
    
        return $stockFromQuandlAPI;
    }
    
}
