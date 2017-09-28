<?php

namespace App\Http\Controllers;

use App\Stock;
use App\Http\Requests;
use App\Custom\Quandl\QuandlApi;
use App\Custom\FinanceOperations\FinanceOperations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class StockController extends Controller 
{
    use FinanceOperations; 
    
    protected $StockAPI; 
    protected $user; 
    protected $userId; 
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->init(); 
    }
    
    private function init() 
    {
        $this->stockAPI = new QuandlAPI();
        $this->user =  Auth::user();
        $this->userId = Auth::id();
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
        $quandlAPI = new QuandlAPI();
        $lastTradedStock = $quandlAPI->getStock($stockBeingSold->symbol);
        
        // Add money to the user's account
        $user->cash = $this->addCash($user, $this->totalRevenue($request->quantity, $lastTradedStock['price']));

        // Remove stock from database 
        $user->stocks()->detach($stockBeingSold->id);
        
    }

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
        $quandlAPI = new QuandlAPI(); 
        
        // Get the api's uri and get the api's stock 
        $uri = $quandlAPI->getURL($stockSymbol);
        $fetchStock = $quandlAPI->getStock($stockSymbol);
        
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
        
        return view('stocks', ['stocks' => $myStocks]);
    }
    
    private function deductCash($user, $amount) 
    {
        $user->cash = $this->withdraw($user->cash, $amount); 
        $user->save();
        
        return $user->cash;
    }
    
    private function addCash($user, $amount) 
    {
        $user->cash = $this->deposit($user->cash, $amount); 
        $user->save(); 
        
        return $user->cash;
    }

    private function doesExist($stock) 
    { 
        return $stock !== null; 
    }
}