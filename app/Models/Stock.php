<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StockHistory;

class Stock extends Model
{
    use HasFactory;
    protected $table = 'stocks';

public function currentPrice()
{
    return StockHistory::where(['stock_id'=>$this->id])->latest()->first()->sum;
}


}
