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

Route::get('/home', 'HomeController@index');
Route::post('/test', 'StockController@store');
Route::get('/test', function() {
    return view('test');
});
Route::get('/stocks', 'StockController@showUserStocks');
Route::post('/purchase', 'StockController@sell');
Route::get('users/{id}/stocks', 'StockController@displayUserStocks');
Route::get('/cache', function() {
   return view('cache'); 
});

Route::get('/components/sell', function() {
    return view('components.sell-stock');
});
// Actual Routes that will be used in Production
Route::get('/search', function() {});
Route::get('/portfolio', 'StockController@getPortfolio');
Route::get('/stocks/{id}', 'StockController@getUserStocks');

Route::post('/portfolio', 'StockController@sell');
