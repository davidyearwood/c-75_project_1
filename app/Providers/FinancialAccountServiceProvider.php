<?php 

namespace App\Providers;

use App\Finance\FinancialAccount; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\ServiceProvider;

class FinancialAccountServiceProvider extends ServiceProvider
{
    
    protected $defer = true;
    
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FinancialAccount::class, function($app) {
            $accountSystem = Auth::user();
            return new FinancialAccount($accountSystem); 
        });
    }
}
