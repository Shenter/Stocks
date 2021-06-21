<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use App\Models\StockHistory;

class UserStocksController extends Controller
{
public function index()
    {
        $stocks = array();
        $user = Auth::user();
        foreach ($user->stocks as $stock)
        {
         $stocks[$stock->id]=array();
        }
        $catalog = array();
         foreach ($stocks as $key=>$val)
            {

            $catalog[$key]['currentPrice'] =  StockHistory::where(['stock_id'=>$key])->latest()->first()->sum;
                $catalog[$key]['avgBuyPrice'] = $this->getAvgBuyprice($key);
             $catalog[$key]['count'] = $this->getCount($key);
            $catalog[$key]['name'] = Stock::where(['id'=>$key])->first()->name;
             $catalog[$key]['id'] = $key;

                $catalog[$key]['change'] = round(( $catalog[$key]['currentPrice']*100/$catalog[$key]['avgBuyPrice'])-100,2);
//                if($delta>0) {
//                    $catalog[$key]['change'] = '+' . $delta;
//                }
//                else
//                {
//                    $catalog[$key]['change'] = '+' . $delta;
//                }
            }



        return view('stocks',['user'=>$user,'catalog'=>$catalog]);
        }



        public function getAvgBuyprice($stockId)
        {
            $sum = 0;
            $prices = DB::table('stock_user')->where(['user_id'=>Auth::id(),'stock_id'=>$stockId,'is_active'=>1])->get('buy_price');
            foreach ($prices as $price) {
                $sum += $price->buy_price;
            }
           // $sum = DB::table('stock_user')->where(['user_id'=>Auth::id(),'stock_id'=>$stockId,'is_active'=>1])->get('buy_price')->buy_price;
            return ($sum/  count($prices));
        }
    public function getCount($stockId)
    {
        return count(DB::table('stock_user')->where(['user_id'=>Auth::id(),'stock_id'=>$stockId,'is_active'=>1])->get());
    }
}
