<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StockHistory;

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



}
