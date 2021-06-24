<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Stock
 * @mixin \Eloquent
 */
class Stock extends Model
{
    public static $TAX = 1;
    use HasFactory;
    protected $table = 'stocks';


    protected $hidden = ['volatility'];

    public function getLatestPrice()
    {
        return StockHistory::where(['stock_id'=>$this->id])->latest()->first()->sum;
    }


    public function getDailyChange()
    {
        return
            round(
                StockHistory::whereDate('created_at',Carbon::today())
                    ->where('stock_id','=',$this->id)
                    ->oldest()
                    ->first()
                    ->sum/
                $this->getLatestPrice()
                -1,3)*100;
    }


//    public function


}
