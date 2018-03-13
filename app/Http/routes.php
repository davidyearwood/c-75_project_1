<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/**
 *  Authentication Routes
 *****************************/
Route::auth();

/**
 *  GET REQUESTS
 * **************************/
Route::get('/', 'StockController@renderPortfolio');
Route::get('/search', 'StockController@renderSearchResult');
Route::get('/portfolio', 'StockController@renderPortfolio'); 
Route::get('/portfolio/{id}', 'StockController@renderStock');
Route::get('/logout', function() {
    Auth::logout(); 
    return redirect('/');
});
Route::post('/search', 'StockController@buyStockAndRenderPortfolio');
Route::post('/portfolio', 'StockController@sellStockAndRenderPortfolio');

// This route is for testing purposes only. 
// Must be removed in production.
Route::get('/material', 'StockController@material');
