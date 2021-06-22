<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use App\Http\Classes\DataPreparer;
use Illuminate\Support\Facades\Auth;


class StockController extends Controller

{
    //

    public function show(Stock $stock)
    {
      $data = DataPreparer::prepareStockData();
        return view ('stock',['stock'=> $stock,'dates'=>$data['dates'],'values'=>$data['values']]);
    }



    public function buy($id)
        {
            $stock = Stock::findorfail($id);
           return view('buystock',['stock'=>$stock, 'howManyStocksCanBuy'=> Auth::user()->howManyStocksCanBuy($id)]);
        }

    public function confirmBuy(Request $request,$stock)
    {
        //TODO Проверка данных на отрицательные и подобное
        $price = $request->price*100;
        $count = $request->count;
        //Если цена в реквесте ниже реальной цены, то это ошибка
        if($price < Stock::findorfail($stock)->getLatestPrice()) {
            return back()->withErrors(['message'=> 'Указана цена ниже, чем готова купить биржа']);
        }
        //Если сумма реквеста +1% меньше его денег, то ошибка
        if($price*  (1+Stock::$TAX/100) * $count > Auth::user()->money  ){

            return back()->withInput()->withErrors(['message'=>'У вас недостаточно денег!']);
        }
        Auth::user()->buyStocks($stock, $count, $price);

        return redirect('stocks')->with(['messages'=>'Успешно куплено '.$count. ' шт. по цене '.$request->price]);
    }

    public function sell($id)
    {
        $stock = Stock::findorfail($id);

        return view('sellstock',['stock'=>$stock, 'howManyStocksCanSell'=> Auth::user()->howManyStocksCanSell($id)]);
    }


    public function confirmSell(Request $request, Stock $stock)
    {//TODO Проверка данных на отрицательные и подобное
        $price = $request->price*100;
        $count = $request->count;


        //Если цена выше, чем текущая, то это ошибка
        if( $price > $stock->getLatestPrice() )
        {
            return back()->withInput()->withErrors(['message'=>'Биржа не купит по такой цене. Обновите страницу и попробуйте еще раз']);
        }

//Проценты вычитаем после продажи, так что их не проверяем
        //Если кол-во меньше, чем есть, то это ошибка
        if(Auth::user()->howManyStocksCanSell($stock->id) < $count)
        {
            return back()->withErrors(['message'=>'У вас нет такого количества!']);
        }
        Auth::user()->sellStocks($stock, $count, $price);
        return redirect('stocks')->with(['messages'=>'Успешно продано '.$count. ' шт. по цене '.$request->price]);

    }




}
