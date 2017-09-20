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
    
    private function getURI($symbol) {
        return 'https://www.quandl.com/api/v3/datasets/WIKI/' . $symbol . '.json';
    }
    public function store(Request $request) {
        
        $this->validate($request, [
            'stockSymbol' => 'required|alpha_num',
            'quantity' => 'numeric'
        ]);
        
        // Information about the user that is login
        $user = Auth::user(); 
        $userId = Auth::id();
        $stockSymbol = $request->stockSymbol;
        
        // Get the api's uri and get the api's stock 
        $uri = $this->getURI($stockSymbol);
        $fetchStock = $this->fetchStock($uri, $stockSymbol);
        
        $stock = Stock::where('symbol', strtoupper($stockSymbol))->first();
        
        if ($this->hasEnoughCash($user->cash, $fetchStock['price'])) {
            // if stock exist, don't create it else create a new stock
            $stock = ($stock !== null) ? $stock : new Stock(
                ['name' => $fetchStock['name'], 'symbol' => $stockSymbol, 'source' => $uri]); 
        
            $user->stocks()->save($stock, ['purchased_price' => $fetchStock['price'], 'quantity' => $request->quantity]);
            $user->cash = $this->newCashAmount($user->cash, $this->totalCost($request->quantity, $fetchStock['price']));
            $user->save();
        } else {
            // Return to the user that they don't have enough money
        }
    }
    
    /**
     * Makes an external api request for historic stock data 
     * 
     * 
     * 
     */    
    private function fetchStock($uri, $symbol) 
    {
        $halfDayInMinutes = 720;
        $symbol = strtolower($symbol);
        $price = Cache::remember($symbol, $halfDayInMinutes, function() use($uri) {
            $client = new Client(); 
            $response = $client->request('GET', $uri);
            $statusCode = $response->getStatusCode(); 
           
            if ($statusCode > 100 && $statusCode < 300) {
             
               $httpBody = json_decode($response->getBody()->getContents());
               $d = [ 'price' => $httpBody->dataset->data[0][4], 
                    'name' => $httpBody->dataset->name ];
               
               return $d; 
           }
           
        });
        
        print_r($price);
        return $price; 
    }
    
    private function clearStockCache() {}
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
    
    public function showUserStocks() 
    {
        $user = Auth::user();
        return view('stocks', ['stocks' => $user->stocks ]);
    }
}