<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Stock; 
use GuzzleHttp\Client; 

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
        $stockData = $this->fetchStockData($uri);
        $stockPrice = $stockData->data[0][4]; 
        
        $stock = Stock::where('name', $stockSymbol)->first();
        // Stock doesn't exist
        if ($stock === null) {
            
            if($this->hasEnoughCash($user->cash, $stockData->data[0][4])) {
                // create new stock
                $stock = new Stock([
                    'name' => strtolower($stockData->name),
                    'symbol' => strtoupper($stockSymbol),
                    'source' => strtolower($uri)
                ]);    
                
                //deduct the money 
                $user->cash = $this->newCashAmount($user->cash, $this->totalCost($request->quantity, $stockPrice));
                $stock->save();
                $user->save();
                // save to the database
                $user->stocks()->save($stock, 
                    [ 'purchased_price' => $stockPrice,
                      'quantity' => $request->quantity ]);
                      
                } else {
                    return 'Doesn\'t have enough cash to make a purchase'; 
                }
                
        } else {
            // check to see if there's enough money for the stock
            if ($this->hasEnoughCash($user->cash, $stockData->data[0][4])) {
                $user->cash = $this->newCashAmount($user->cash, $this->totalCost($request->quantity, $stockPrice));
                $user->save(); 
                $user->stocks()->save($stock, ['purchased_price' => $stockPrice, 'quantity' => $request->quantity ]);
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
    private function fetchStockData($uri) 
    {
        $client = new Client(); 
        $response = $client->request('GET', $uri);
        
        if ($response->getStatusCode() >= 300) {
            throw new Exception('Unable to fulfil request. Retrived a status code of ' . $response->getStatusCode());
        }
            
        // Convert stream content to json 
        $body = json_decode($response->getBody()->getContents());
        $data = $body->dataset; 
        
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