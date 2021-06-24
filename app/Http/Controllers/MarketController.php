<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Stock;
use App\Models\StockHistory;

class MarketController extends Controller
{
    public function show()
    {
        $stocks = Stock::all();
        return view('market',['stocks'=>$stocks]);
    }
}
