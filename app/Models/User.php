<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Stock;
use App\Models\StockUser;


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


    public function getMoney()
    {
        return 666;
    }

    public function stocks()
    {
        return $this->belongsToMany(Stock::class,)->wherePivot('is_active',1)->withPivot('buy_price');
    }
//    public function userHasStocks($stockId)
//    {
//        return StockUser::where(['user_id'=>$this->id,'stock_id'=>$stockId,'is_active'=>1])->exists();
//    }

    public function howManystockscanBuy($stockId)
    {
        $stock = Stock::find($stockId);
        return floor($this->money/$stock->getLatestPrice() *0.99 );
    }
    public function howManystockscanSell($stockId)
    {

        return StockUser::where(['is_active'=>1, 'user_id'=>$this->id,'stock_id'=>$stockId])->get()->count();
    }


    public function buyStocks($stock, $count, $price)
    {
        $cost = round($price*$count* (1+ Stock::$TAX/100) ,2);
     //   $user = Auth::user();
       $this->money -= $cost;
       $this->save();
       for ($i=0;$i<$count;$i++) {
           $stockuser = new StockUser([
               'created_at' => date('Y-m-d H:i:s', time()),
               'updated_at' => date('Y-m-d H:i:s', time()),
               'stock_id' => $stock,
               'user_id' => $this->id,
               'buy_price' => $price,
           ]);
           $stockuser->save();
       }
    }

    public function sellStocks($stock, $count, $price)
    {
        $cost =  round($count*$price*  (1- Stock::$TAX/100) );
        $this->money += $cost;
        $this->save();
        StockUser::where(['is_active'=>1, 'user_id'=>$this->id,'stock_id'=>$stock->id])->take($count)->update(['is_active'=>false]);

    }

}
