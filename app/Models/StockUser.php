<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockUser extends Model
{
    use HasFactory;
    protected $fillable = ['updated_at','created_at','stock_id' ,'user_id', 'buy_price'];
    protected $table='stock_user';
}
