<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class StockUser extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = ['updated_at','created_at','stock_id' ,'user_id', 'buy_price'];
    protected $table='stock_user';


//    public function getStock
    public function getAvgBuyPrice($stockId)
    {

        $prices = $this::where(['user_id'=>Auth::id(),'stock_id'=>$stockId])->avg('buy_price');

        return($prices/100);

    }



    public function getCount($stockId):int
    {
        return count($this::where(['user_id'=>Auth::id(),'stock_id'=>$stockId])->get());
    }

}
