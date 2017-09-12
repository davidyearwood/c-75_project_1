<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Stock; 
use GuzzleHttp\Client; 
use Illuminate\Support\Facades\Cache;

class StockController extends Controller 
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Store a stock symbol 
     * 
     * 
     * 
     */
    public function store(Request $request) {
        
        $this->validate($request, [
            'stockSymbol' => 'required|alpha_num',
            'quantity' => 'numeric'
        ]);
        
        // Information about the user that is login
        $user = Auth::user(); 
        $userId = Auth::id();
        $stockSymbol = $request->stockSymbol;
        
        $uri = 'https://www.quandl.com/api/v3/datasets/WIKI/' . $stockSymbol . '.json';
        $stockData = $this->fetchStockData($uri, $stockSymbol);
        $stockPrice = $stockData->data[0][4]; 
        
                
        $stock = Stock::where('name', $stockSymbol)->first();
        // Stock does exist
        if ($stock !== null) {
            
            if($this->hasEnoughCash($user->cash, $stockPrice)) {
                $user->stocks()->save($stock, ['purchased_price' => $stockPrice, 'quantity' => $request->quantity]);
            
                $user->cash = $this->newCashAmount($user->cash, $this->totalCost($request->quantity, $stockPrice));
                $user->save();
            }
                
        } 
        
        echo $stockSymbol;
        var_dump($stockData->data[0][4]);
 
    }
    
    /**
     * Makes an external api request for historic stock data 
     * 
     * 
     * 
     */    
    private function fetchStockData($uri, $symbol) 
    {
        $halfDayInMinutes = 720;
        
        $data = Cache::remember($symbol, $halfDayInMinutes, function() {
           $client = new Client(); 
           $response = $client->request('GET', $uri);
           $statusCode = $response->getStatusCode(); 
           
           if ($statusCode > 100 && $statusCode < 300) {
               $httpBody = json_decode($response->getBody()->getContents());
               return $httpBody->dataset; 
           }
           
        });
        
        return $data; 
    }
    
    /**
     * Makes an external api request for historic stock data 
     * 
     * 
     * 
     */      
    private function hasEnoughCash($wallet, $cost) 
    {
        return ( $wallet >= $cost ? true : false );
    }
    
    private function totalCost($quantity, $price) 
    {
        return $quantity * $price; 
    }
    
    private function newCashAmount($wallet, $cost) 
    {
        return $wallet - $cost; 
    }
    
}