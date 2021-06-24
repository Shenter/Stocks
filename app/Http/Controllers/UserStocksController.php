<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockHistory;
use App\Models\StockUser;
use Illuminate\Support\Facades\Auth;


class UserStocksController extends Controller
{
public function index()
    {
        $stocks = $catalog = array();

        $user = Auth::user();

        foreach ($user->stocks as $stock)
        {
            $stocks[$stock->id]=array();

        }
         foreach ($stocks as $key=>$val)
            {
            $catalog[$key]['currentPrice'] =  StockHistory::where(['stock_id'=>$key])->latest()->first()->sum/100;
            $catalog[$key]['avgBuyPrice'] = StockUser::where(['stock_id'=>$key])->first()->getAvgBuyPrice($key);


            $catalog[$key]['count'] = $this->getCount($key);
            $catalog[$key]['name'] = Stock::where(['id'=>$key])->first()->name;
            $catalog[$key]['id'] = $key;
            $catalog[$key]['change'] = round(
                ( $catalog[$key]['currentPrice']
                    *100/$catalog[$key]['avgBuyPrice'])
                -100,2);
            $catalog[$key]['userHasMoneyToBuyStock'] = $this->userHasMoneyToBuyStock($key);
            }
        return view('stocks',['catalog'=>$catalog]);
        }





    public function getCount($stockId):int
    {
        return (StockUser::where(['user_id'=>Auth::id(),'stock_id'=>$stockId])->count());
    }

//    public function userHasStock($stockId):bool
//    {
//        return StockUser::where(['user_id'=>Auth::id(),'stock_id'=>$stockId])->exists();
//    }

    public function userHasMoneyToBuyStock($stockId):bool
    {
        $stock = Stock::findorfail($stockId);
        return Auth::user()->money
            >= $stock->getLatestPrice();
    }


}
