<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;

class MarketController extends Controller
{
    //
    public function show()
    {
        $stocks = Stock::all();
        return view('market',['stocks'=>$stocks]);
    }
}
