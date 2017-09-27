<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Stock; 
use GuzzleHttp\Client; 
use Illuminate\Support\Facades\Cache;
use App\Custom\FinanceOperations\FinanceOperations;

class StockController extends Controller 
{
    use FinanceOperations; 
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    private function generateApiURL($symbol) 
    { 
        return 'https://www.quandl.com/api/v3/datasets/WIKI/' . $symbol . '.json'; 
        
    }
    
    private function getURI($symbol) 
    {
        return 'https://www.quandl.com/api/v3/datasets/WIKI/' . $symbol . '.json';
    }
    

    public function sell(Request $request) 
    {
        $this->validate($request, [
            'id' => 'numeric|min:0',
            'quantity' => 'numeric|min:0'
        ]);
        
        $userID = Auth::id();
        $user = Auth::user();
        $stockBeingSold = $user->stocks()->wherePivot('id', '=', $request->id)->wherePivot('user_id', '=', $userID)->first();
        $apiURL = $this->getURI($stockBeingSold->symbol);
        $lastTradedStock = $this->fetchStock($apiURL, $stockBeingSold->name);
        
        // Add money to the user's account
        $user->cash = $this->addCash($user, $this->totalRevenue($request->quantity, $lastTradedStock['price']));

        // Remove stock from database 
        $user->stocks()->detach($stockBeingSold->id);
        
    }
    private function doesExist($stock) { return $stock !== null; }
    public function store(Request $request) 
    {
        $this->validate($request, [
            'stockSymbol' => 'required|alpha_num',
            'quantity' => 'numeric|min:0'
        ]);
        
        // Information about the user that is login
        $user = Auth::user(); 
        $userId = Auth::id();
        $stockSymbol = $request->stockSymbol;
        
        // Get the api's uri and get the api's stock 
        $uri = $this->getURI($stockSymbol);
        $fetchStock = $this->fetchStock($uri, $stockSymbol);
        
        $stock = Stock::where('symbol', strtoupper($stockSymbol))->first();
        
        if ($this->hasEnough($user->cash, ($fetchStock['price']) * $request->quantity)) {
            // if stock exist, don't create it else create a new stock
            if (!$this->doesExist($stock)) {
                $stock = new Stock(['name' => $fetchStock['name'], 'symbol' => $stockSymbol, 'source' => $uri]); 
            }
            
            $user->stocks()->save($stock, ['purchased_price' => $fetchStock['price'], 'quantity' => $request->quantity]);
            $this->deductCash($user, ($fetchStock['price'] * $request->quantity)); 
        } else {
            return redirect('test')->with('notEnoughCash', 'not enough cash!');
        }
    }
    
    private function deductCash($user, $amountBeingDeducted) 
    {
        $currentAmountOfCash = $user->cash; 
        $user->cash = $currentAmountOfCash - $amountBeingDeducted; 
        $user->save();
        return $user->cash;
    }
    
    private function addCash($user, $amount) 
    {
        $currentAmountOfCash = $user->cash;
        $user->cash += $amount; 
        $user->save(); 
        
        return $user->cash;
    }
    
    private function totalRevenue($quantity, $price) 
    {
        return $price * $quantity;    
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
        
        $data = Cache::remember($symbol, $halfDayInMinutes, function() use($uri) {
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
        
        return $data; 
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
    
    public function showUserStocks() 
    {
        $user = Auth::user();
        return view('stocks', ['stocks' => $user->stocks ]);
    }
    // render list of stocks
    public function displayUserStocks($id) 
    {
        if ((int)$id !== (int)Auth::id()) 
        {
            abort(404);
        }
        
        $user = Auth::user();
        $myStocks = $user->stocks; 
        
        print("</ul>");
        return view('stocks', ['stocks' => $myStocks]);
    }
}