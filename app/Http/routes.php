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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();


// Actual Routes that will be used in Production
Route::get('/portfolio/{id}', 'StockController@showUserStocks');

// Get Requests
// When I search for a stock
// When I view my portfolio 
Route::get('/search', 'StockController@showSearchResult');
Route::get('/portfolio', 'StockController@showPortfolio');

// Post requests 
// When you sell a stock 
// when you purhcase a stock 
Route::post('/portfolio', 'StockController@showPortfolioAfterSale');
Route::post('/search', 'StockController@showPortfolioAfterPurchase');

// Routes for testing design

Route::get("/design", function() {
   return view("layouts/master", ["user" => Auth::user()]); 
});