<?php namespace App\Http\Controllers;

use App\Stock;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\HttpClient\QuandlClient; 
use App\Finance\FinancialAccount; 
use App\Finance\FinancialCalculator;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller 
{
    protected $quandlClient; 
    protected $user; 
    protected $financialAccount;
    
    public function __construct(FinancialAccount $account, QuandlClient $client)
    {
        $this->middleware('auth');
        
        /* Dependencies */ 
        $this->quandlClient = $client;
        $this->user = Auth::user();
        $this->financialAccount = $account;
    }
    
    /**
     * Get the search result for the requested  
     * stock.
     * 
     * @param Request $request
     * @return Array
     */
    private function search(Request $request) 
    {
        if (!$request->has('q')) {
            return null; 
        }
        
        $this->validate($request, [
            'q' => 'alpha_num'    
        ]);
        
        $query = $request->input('q');
        
        
        $stock = $this->quandlClient->getStock($query);

        $stock['symbol'] = $query;  
        
        return $stock;
    }
    
    /**
     * Sells stock, and updates user database 
     * 
     * @param Request $request
     * @return Boolean
     */
    private function sell(Request $request) 
    {
        $rules = [
            'id' => 'numeric|min:1',
            'quantity' => 'numeric|min:0'
        ];
        
        $this->validate($request, $rules);
        
        $stock = [
            'db' => $this->user->stocks()->wherePivot('id', '=', $request->id),
        ];
        
        $stock['quandl'] = $this->quandlClient->getStock($stock['db']->first()->symbol);
        
        $revenueEarned = FinancialCalculator::salesRevenue($request->quantity, $stock['quandl']['price']);
        $maxQuantity = $stock['db']->first()->pivot->quantity; 
        
        if ($request->quantity == $maxQuantity) {
            $this->financialAccount->deposit($revenueEarned);
            $stock['db']->detach(); // not sure this will work 
            return true; 
        } elseif ($request->quantity <= $maxQuantity) {
            $this->financialAccount->deposit($revenueEarned);
            $stock['db']->updateExistingPivot($stock['db']->first()->id, ['quantity' => $stock['db']->first()->pivot->quantity - $request->quantity]);
            return true;
        } else {
            return false; 
        }
    }
    
    /**
     * Renders the view for the search result. 
     * 
     * @param Request
     * @return View
     */
    public function showSearchResult(Request $request) 
    {
        $searchResult = $this->search($request);
        
        print_r($searchResult);
        return view('search', ['stock' => $searchResult, 
                               'user' => $this->user, 
                               'error' => $this->quandlClient->getError() || []]);    
    }
    
    // purchase
    public function store(Request $request) 
    {
        $this->validate($request, [
            'stock' => 'required|alpha_num',
            'quantity' => 'numeric|min:0'
        ]);
        
        // Information about the user that is login
        $symbol = $request->stock;
        // Get the api's uri and get the api's stock 
        $uri = $this->quandlClient->getURL($symbol);
        $fetchStock = $this->quandlClient->getStock($symbol);
        
        $stock = Stock::where('symbol', strtoupper($symbol))->first();
        
        
        $expense = FinancialCalculator::expense($request->quantity, $fetchStock['price']);
        // if you don't have enough money to purchase 
        if (!$this->financialAccount->hasEnough($expense)) {
            return false;
        }
        
        // if stock doesn't exist, create one
        if ($stock == null) {
            $stock = new Stock(['name' => $fetchStock['name'],
                                'symbol' => $symbol, 
                                'source' => $uri]);
        }
        
        $this->user->stocks()->save($stock, ['purchased_price' => $fetchStock['price'],
                                             'quantity' => $request->quantity]);
        

        $this->financialAccount->withdraw($expense);
        
        return true;  
    }

    
    public function showPortfolioAfterPurchase(Request $request) 
    {
        $isPurchased = $this->store($request);
        
        if (!$isPurchased) {
            // throw some error 
            abort(500);
        }
        
        return $this->showPortfolio(); 
    }
    
    /**
     * Show the user their portfolio after selling a stock
     * 
     * @param Request
     * @return View 
     */
    public function showPortfolioAfterSale(Request $request) {
        $hasSold = $this->sell($request);
        
        if (!$hasSold) {
            abort(500);
        }
        
       return $this->showPortfolio();
    }
    
    public function showPortfolio() {
        return view('app.portfolio', 
            ['user' => $this->user, 
             'stocks' => $this->user->stocks]);
    }
    
    // ?? 
    public function showUserStocks($id) {
        $stock = $this->user->stocks()
                    ->wherePivot('id', '=', $id)
                    ->first();
                    
        return view('user-stocks', [
            'stock' => $stock,  
            'user' => $this->user
            ]); 
    }
}