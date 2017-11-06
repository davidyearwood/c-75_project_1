<?php

namespace App\Providers;

use GuzzleHttp\Client;
use App\HttpClient\QuandlClient;
use Illuminate\Support\ServiceProvider;

class HttpClientServiceProvider extends ServiceProvider
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
        $this->app->bind(QuandlClient::class, function($app) {
            $client = $app->make(Client::class);
            return new QuandlClient($client); 
        });
    }
}
