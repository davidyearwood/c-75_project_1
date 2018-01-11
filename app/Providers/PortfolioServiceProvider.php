<?php

namespace App\Providers;

use App\Finance\Portfolio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class PortfolioServiceProvider extends ServiceProvider
{
    protected $defer = true; 
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(Portfolio::class, function($app) {
           $user = Auth::user(); 
           return new Portfolio($user);
        });
    }
}
