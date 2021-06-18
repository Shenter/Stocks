<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
Route::middleware('auth')->get('/stocks', 'App\Http\Controllers\UserStocksController@index' )->name('stocks');

Route::middleware('auth')->get('/stock/{stock}', 'App\Http\Controllers\StockController@show' )->name('stock.show');
Route::middleware('auth')->get('/market', 'App\Http\Controllers\MarketController@show' )->name('market.show');

require __DIR__.'/auth.php';
