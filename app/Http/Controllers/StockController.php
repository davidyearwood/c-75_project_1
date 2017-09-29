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
    
    public function sell(Request $request) 
    {
        $this->validate($request, [
            'id' => 'numeric|min:0',
            'quantity' => 'numeric|min:0'
        ]);
        
        $stockBeingSold = $this->user->stocks()->wherePivot('id', '=', $request->id)->wherePivot('user_id', '=', $this->userId)->first();
        $lastTradedStock = $this->stockAPI->getStock($stockBeingSold->symbol);
        
        $totalRevenueEarned = $this->totalRevenue($request->quantity, $lastTradedStock['price']);
        $this->addCash($totalRevenueEarned);
       
        if ($request->quantity == $stockBeingSold->pivot->quantity) {
            $this->user->stocks()->wherePivot('id', '=', $request->pid)->detach();
        } elseif ($request->quantity > $stockBeingSold->pivot->quantity) {
            abort(500);
        } else {
            $this->user->stocks()->wherePivot('id', '=', $request->pid)->updateExistingPivot($stockBeingSold->id, ['quantity' => $stockBeingSold->pivot->quantity - $request->quantity]);
        }
    
    }
    
    public function store(Request $request) 
    {
        $this->validate($request, [
            'stockSymbol' => 'required|alpha_num',
            'quantity' => 'numeric|min:0'
        ]);
        
        // Information about the user that is login
        $stockSymbol = $request->stockSymbol;
        
        // Get the api's uri and get the api's stock 
        $uri = $this->stockAPI->getURL($stockSymbol);
        $fetchStock = $this->stockAPI->getStock($stockSymbol);
        
        $stock = Stock::where('symbol', strtoupper($stockSymbol))->first();
        $totalCost = $this->totalRevenue($request->quantity, $fetchStock['price']);
        
        if ($this->hasEnough($this->user->cash, $totalCost)) {
            // if stock exist, don't create it else create a new stock
            if (!$this->doesExist($stock)) {
                $stock = new Stock(['name' => $fetchStock['name'], 'symbol' => $stockSymbol, 'source' => $uri]); 
            }
            
            $this->user->stocks()->save($stock, ['purchased_price' => $fetchStock['price'], 'quantity' => $request->quantity]);
            $this->deductCash(($fetchStock['price'] * $request->quantity)); 
        } else {
            return redirect('test')->with('notEnoughCash', 'not enough cash!');
        }
    }
    
    // render list of stocks
    public function displayUserStocks($id) 
    {
        if ((int)$id !== (int)$this->userId) {
            abort(404);
        }
        
        return view('stocks', ['stocks' => $this->user->stocks]);
    }
    
    
    public function remove($id) 
    {
        $this->user->stocks()->detach($id);
    }
    
    private function deductCash($amount) 
    {
        $this->user->cash = $this->withdraw($this->user->cash, $amount); 
        $this->user->save();
        
        return $this->user->cash;
    }
    
    private function addCash($amount) 
    {
        $this->user->cash = $this->deposit($this->user->cash, $amount); 
        $this->user->save(); 
        
        return $this->user->cash;
    }

    private function doesExist($stock) 
    { 
        return $stock !== null; 
    }
    
    private function init() 
    {
        $this->stockAPI = new QuandlAPI();
        $this->user =  Auth::user();
        $this->userId = Auth::id();
    }
}