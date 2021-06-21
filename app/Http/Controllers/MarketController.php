<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\StockHistory;

class MarketController extends Controller
{
    //
    public function show()
    {
        $stocks = Stock::all();
        $stocksChangebyDay=[];
        foreach ($stocks as $stock) {
            $stocksChangebyDay[$stock->id]=[]  ;
            }
        foreach ($stocksChangebyDay as $key=>$value)
        {
            $stocksChangebyDay[$key]['change'] =
                StockHistory::whereDate('created_at',Carbon::today())->oldest()->first();
        }
        dd($stocksChangebyDay);

        return view('market',['stocks'=>$stocks]);
    }
}
