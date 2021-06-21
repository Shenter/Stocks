<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use App\Http\Classes\DataPreparer;


class StockController extends Controller

{
    //

    public function show(Stock $stock)
    {
      $data = DataPreparer::prepareData(request());

      $period = request()->period ??'day' ;
      switch ($period) {
        case 'day':
        $datesHistory = DB::table('stock_histories')->where(['stock_id'=>$stock->id])->oldest()->get('updated_at')->take(1440);
        $valuesHistory = DB::table('stock_histories')->where(['stock_id'=>$stock->id])->oldest()->get('sum')->take(1440);
        $chunks = $valuesHistory->chunk(60);

        foreach ($chunks as $chunk) {
      //    $collection = collect($chunk);
          echo $chunk->avg('sum')."<br>";
        }
          break;

        default:
        $datesHistory = DB::table('stock_histories')->where(['stock_id'=>$stock->id])->get('updated_at');
        $valuesHistory = DB::table('stock_histories')->where(['stock_id'=>$stock->id])->get('sum');
          break;
      }
        {

        }


      $values = '[';
      // foreach ($datesHistory as $key => $value) {
      //   $dates = $dates.$value->updated_at.', ';
      // }
      foreach ($valuesHistory as $key => $value) {
        $sum = ($value->sum)/100;
        $values = $values.$sum.', ';
      }
      // $dates=$dates.']';
      $values=$values.']';
        return view ('stock',['stock'=> $stock,'dates'=>$datesHistory,'values'=>$values]);
    }
}
