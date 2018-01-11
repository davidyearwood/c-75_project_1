<?php 

namespace App\Finance; 

use Illuminate\Support\Facades\Auth;

/** 
 * @author David <dyearwoodd@gmail.com>
 * 
 * Retrieves portfolio information
 */ 
class Portfolio {
    
    protected $user; 
    
    public function __construct($user) 
    {
        $this->user = $user;
    }
    
    public function totalAsset() 
    {
        $asset = 0; 
        
        foreach($this->user->stocks as $stock) {
            $asset = $asset + ($stock->last_trade_price * $stock->pivot->quantity);
        }
        
        return $asset; 
    }
    
    public function totalNetValue() 
    {
        return $this->totalAsset() + $this->user->cash;
    }
    
    public function getStocks() 
    {
        return $this->user->stocks; 
    }
    
    public function getStockBySymbol($symbol) 
    {
        return $this->user->stocks()->where("symbol", $symbol)->get();
    }
    
}