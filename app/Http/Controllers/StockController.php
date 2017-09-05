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
        
        $stock = Stock::where('name', $stockSymbol)->first();
        
        if ($this->hasEnoughCash($user->cash, $stockData->data[0][4])) {
            $user->cash = $this->newCashAmount($user->cash, $this->totalCost($request->quantity, $stockData->data[0][4]));
            $stock = new Stock([
                'name' => $stockData->name, 
                'symbol' => strtoupper($stockSymbol),
                'source' => $uri
            ]);
            
            $user->stocks()->save($stock, 
                [ 'purchased_price' => $stockData->data[0][4],
                  'quantity' => $request->quantity]);
                  
            $user->save();
        } else {
            echo 'Doesn\'t have enough money to purchase stock(s).';
        }
        if (!$stock) {
            // Add to stock to the database
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