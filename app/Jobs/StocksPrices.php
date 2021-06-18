<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class StocksPrices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $stocks = Stock::all();
        foreach ($stocks as $stock)
        {

            $lastsum =
                DB::table('stock_histories')->where('stock_id','=',$stock->id)->latest()->limit(1)->first()->sum;
            logger($lastsum);
            $prelatestsum =
                DB::table('stock_histories')->where('stock_id','=',$stock->id)->latest()->skip(1)->first()->sum;
            logger('Последняя цена - '.$lastsum);
            logger('Предпоследняя цена - '.$prelatestsum);
            if($lastsum-$prelatestsum <0)
            {
                $direction='-';
            }
            else
            {
                $direction='+';
            }
            if(rand(1,10)<4)
            {
                if($direction=='-')
                {$direction='+';}
                else
                {$direction='-';}
            }
           // $direction = rand(-8,9) < 0 ? '-':'+' ;
            if($direction=='+') {
                $randomator = rand(0, 100);
                if ($randomator < 70)
                    $change = rand(1, 3);
                if ($randomator >= 70 && $randomator < 90)
                    $change = rand(3, 5);
                if ($randomator >= 90 && $randomator <= 99)
                    $change = 6;
                if ($randomator == 100)
                    $change = 10;
            }
            if($direction=='-') {
                $randomator = rand(0, 100);
                if ($randomator < 60)
                    $change = -rand(1, 3);
                if ($randomator >= 60 && $randomator < 80)
                    $change = -rand(3, 5);
                if ($randomator >= 80 && $randomator <= 99 )
                    $change = -7;
                if ($randomator ==100 )
                    $change = -10;
            }
            $change/=10;
            logger('Change = '.$change);
            DB::table('stock_histories')->insert([
                'id'=>null,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
                'stock_id'=>$stock->id,
                'sum'=>$lastsum+$lastsum/100*($change)
                ]);

            //с вероятностью 70% цена продолжит предыдущее движение вниз или вверх
            //При росте:
            //70%, что цена меняется от 0.1% до 0.5%
            //20%, что цена меняется от 0.5% до 0.8%
            //9% что цена меняется от 0.8% до 1%
            //1%, что цена меняется на 1.5%


            //При падении:
            //60%, что цена меняется от 0.1% до 0.5%
            //30%, что цена меняется от 0.5% до 0.8%
            //10% что цена меняется от 0.8% до 1%


            //Надо добавить падение после дивидендов
            echo $direction;
        }
    }
}
