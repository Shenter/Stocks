<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\StocksPrices;


class TestController extends Controller

{
    //

    public function mln()
    {
      for($i=0;$i<1000;$i++)
        {
          dispatch (new StocksPrices());
          sleep(2);
        }
    }
}
