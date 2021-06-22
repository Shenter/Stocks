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
            $latestPrice = Stock::findorfail($key);

            $stocksChangebyDay[$key]['change'] =
               round(
                StockHistory::whereDate('created_at',Carbon::today())->where('stock_id','=',$key)->oldest()->first()->sum/
                $latestPrice->getLatestPrice()
            -1,3)*100;

        }
        dd ($stocksChangebyDay);
        return view('market',['stocks'=>$stocks]);
    }
}
