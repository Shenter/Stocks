<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Stock;

class UserStocksController extends Controller
{
public function index()
    {
        $user = Auth::user();
         foreach ($user->stocks as $stock)
            {
             $stock->currentPrice = Stock::find($stock->id)->currentPrice();
            }

        return view('stocks',['user'=>$user]);
        }

}
