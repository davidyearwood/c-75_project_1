<?php namespace App\Http\Controllers;

use App\Stock;
use App\Http\Requests;
use App\Finance\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\HttpClient\QuandlClient; 
use App\Finance\FinancialAccount; 
use App\Finance\FinancialCalculator;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller 
{
    /*
    *--------------------------------------------------
    * Stock Controller
    *--------------------------------------------------
    * 
    * This controller performs CRUD operations 
    *
    *
    */ 
    protected $quandlClient; 
    protected $user; 
    protected $financialAccount;
    protected $portfolio; 
    
    public function __construct(FinancialAccount $account, QuandlClient $client)
    {
        $this->middleware('auth');
        
        /* Dependencies */ 
        $this->quandlClient = $client;
        $this->user = Auth::user();
        $this->financialAccount = $account;
        $this->portfolio = new Portfolio($this->user);
    }
    
    /**
     * Returns the search result for the requested  
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
        
        $historicData = ['symbol' => $stock['db']->first()->symbol, 'quantity' => $request->quantity];
        
        $revenueEarned = FinancialCalculator::salesRevenue($request->quantity, $stock['quandl']['price']);
        $maxQuantity = $stock['db']->first()->pivot->quantity; 
        
        if ($request->quantity == $maxQuantity) {
            $this->financialAccount->deposit($revenueEarned);
            $stock['db']->detach(); // not sure this will work 
            return $historicData; 
        } elseif ($request->quantity <= $maxQuantity) {
            $this->financialAccount->deposit($revenueEarned);
            $stock['db']->updateExistingPivot($stock['db']->first()->id, ['quantity' => $stock['db']->first()->pivot->quantity - $request->quantity]);
            return $historicData;
        } else {
            return false; 
        }
    }
    
    /**
     * Stores the request in the db  
     * 
     * 
     * @param Request $request
     * @return boolean
     */
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
        
        return ['quantity' => $request->quantity, 'symbol' => $symbol];  
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
        
       return view();
    }
    
    /**
     * Renders portfolio.  
     * 
     * @return View
     */ 
    public function renderPortfolio() 
    {
        $pData = [
            'user' => $this->user, 
            'stocks' => $this->user->stocks, 
            'netValue' => $this->portfolio->totalNetValue(),
            'totalAsset' => $this->portfolio->totalAsset()
        ];
        
        return view('pages.portfolio', $pData); 
    }
    
    /**
     * Renders Stock.  
     * 
     * @param INT $id
     * @return View
     */
    public function renderStock($id) {
        $stock = $this->user->stocks()
                    ->wherePivot('id', '=', $id)
                    ->first();
                    
        return view('pages/stock', [
            'stock' => $stock,  
            'user' => $this->user,
            'netValue' => $this->portfolio->totalNetValue(),
            'totalAsset' => $this->portfolio->totalAsset()
        ]); 
    }  
    
    /**
     * Renders the view for the search result. 
     * 
     * @param Request
     * @return View
     */
    public function renderSearchResult(Request $request) 
    {
        $searchResult = $this->search($request);
        
        $data = [
            'user' => $this->user, 
            'stock' => $searchResult, 
            'netValue' => $this->portfolio->totalNetValue(),
            'totalAsset' => $this->portfolio->totalAsset()
        ];
        
        return view('pages.search', $data);
    }
    
    public function material() {
        return view('layouts.material', 
        ['user' => $this->user, 'totalAsset' => $this->portfolio->totalAsset(), 'netValue' => $this->portfolio->totalNetValue()]);
    }

    /**
     * Stores the request into the db and redirect them 
     * to the portfolio page after.
     * 
     * @param Request
     * @return View
     */ 
    public function buyStockAndRenderPortfolio(Request $request) 
    {
        $purchased = $this->store($request);
        
        if (!$purchased) {
            // send a log to me 
            abort(500, "We were unable to purchase the requested stock. Try going back and purchasing the stocks.");
        } 
        
        return redirect('portfolio')->with('success', "You purchased {$purchased['quantity']} share(s) of {$purchased['symbol']}!");
    }
    
    public function sellStockAndRenderPortfolio(Request $request) 
    {
        $sold = $this->sell($request); 
        
        if (!$sold) {
            // send a log to me 
            abort(500, "It looks like we were unable to sell your shares. Try going back to your portfolio and try again.");
        }
        
        return redirect('portfolio')->with('success', "You sold {$sold['quantity']} share(s) of {$sold['symbol']}!");
    }
}

