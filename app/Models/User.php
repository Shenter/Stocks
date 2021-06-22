<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function stocks():\Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Stock::class)->wherePivot('is_active',1)->withPivot('buy_price');
    }


    public function howManyStocksCanBuy($stockId):int
    {
        $stock = Stock::find($stockId);
        return floor($this->money/$stock->getLatestPrice() * 0.99 );
    }
    public function howManyStocksCanSell($stockId)
    {

        return StockUser::where(['is_active'=>1, 'user_id'=>$this->id,'stock_id'=>$stockId])->get()->count();
    }

    /**
     * @param $stock
     * @param $count
     * @param $price
     */
    public function buyStocks($stock, $count, $price)
    {
        $cost = round($price*$count* (1 + Stock::$TAX/100) ,2);
        $adminMoney = DB::table('admin_money')->first()->sum + $price*$count* (Stock::$TAX/100);
        DB::table('admin_money')->update(['sum'=>$adminMoney]);
       $this->money -= $cost;
       $this->save();
       for ($i=0;$i<$count;$i++) {
           $stockUser = new StockUser([
               'created_at' => date('Y-m-d H:i:s', time()),
               'updated_at' => date('Y-m-d H:i:s', time()),
               'stock_id' => $stock,
               'user_id' => $this->id,
               'buy_price' => $price,
           ]);
           $stockUser->save();
       }
    }

    public function sellStocks($stock, $count, $price)
    {
        $cost = round($count * $price * (1 - Stock::$TAX / 100));
        $adminMoney = DB::table('admin_money')->first()->sum + $price * $count * (Stock::$TAX / 100);
        DB::table('admin_money')->update(['sum' => $adminMoney]);
        $this->money += $cost;
        $this->save();
        StockUser::where(['is_active' => 1, 'user_id' => $this->id, 'stock_id' => $stock->id])->take($count)->update(['is_active' => false]);
    }

}
