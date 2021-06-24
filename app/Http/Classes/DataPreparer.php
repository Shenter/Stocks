<?php

namespace App\Http\Classes;

use  Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class DataPreparer
{

    public static function prepareStockData(): array
    {
        $period = request()->period ?? 'day';
        $stock = request()->stock;
        $valuesHistory = $datesHistory = null;
        switch ($period) {
            case 'day':
            {
                $datesHistory = DB::table('stock_histories')
                    ->where(['stock_id' => $stock->id])
                    ->oldest()
                    ->get('created_at')
                    ->take(-144);
                $valuesHistory = DB::table('stock_histories')
                    ->where(['stock_id' => $stock->id])
                    ->oldest()
                    ->get('sum')
                    ->take(-144);

                break;
            }
            case 'month':
            {
                $datesHistory = DB::table('stock_histories')
                    ->select(DB::raw(('date(created_at) as created_at')))
                    ->groupByRaw('date(created_at)')
                    ->limit(-30)
                    ->get();
                foreach ($datesHistory as $item) {
                    $valuesHistory[] = DB::table('stock_histories')
                        ->where(['stock_id' => $stock->id])
                        ->whereDate('created_at', '=', $item->created_at)
                        ->avg('sum');
                }
                break;
            }

            default:
                $datesHistory = DB::table('stock_histories')
                    ->where(['stock_id' => $stock->id])
                    ->latest()
                    ->get('created_at');
                $valuesHistory = DB::table('stock_histories')
                    ->where(['stock_id' => $stock->id])
                    ->latest()
                    ->get('sum');
                break;
        }

        $values = self::wrapValuesHistory($valuesHistory);

        return ['dates' => $datesHistory, 'values' => $values];
    }
    public static function wrapValuesHistory($valuesHistory):string
    {
        $values = '[';
        foreach ($valuesHistory as $key => $value) {
            $sum = $value->sum ?? $value  ?? 0;
            $sum = round($sum/100,2);
            $values = $values . $sum . ', ';
        }
        return $values . ']';
    }

    public static function prepareUserCash():array
    {
        $period = request()->period ?? 'day' ;
        switch ($period) {
            case 'day':
            {
                $datesHistory = DB::table('users_cash')
                    ->where(['user_id'=>Auth::user()->id])
                    ->oldest()
                    ->get('created_at')
                    ->take(-144);
                $valuesHistory = DB::table('users_cash')
                    ->where(['user_id'=>Auth::user()->id])
                    ->oldest()
                    ->get('sum')
                    ->take(-144);
                foreach ($datesHistory as $dateHistory)
                {
                    $dateHistory->created_at=date('H:i',strtotime($dateHistory->created_at));
                }
                break;
            }
            case 'month':
            {
                $datesHistory = DB::table('users_cash')
                    ->select(DB::raw(('date(created_at) as created_at')))
                    ->where(['user_id'=>Auth::user()->id])
                    ->groupByRaw('date(created_at)')
                    ->oldest()
                    ->get('created_at')
                    ->take(-30);
            foreach ($datesHistory as $item) {
                $valuesHistory[] = DB::table('users_cash')
                    ->where(['user_id'=>Auth::user()->id])
                    ->whereDate('created_at', '=', $item->created_at)
                    ->avg('sum');
                }
            }
            default:
            {
                $datesHistory = DB::table('users_cash')
                    ->select(DB::raw(('date(created_at) as created_at')))
                    ->where(['user_id' => Auth::user()->id])
                    ->groupByRaw('date(created_at)')
                    ->latest()
                    ->get('created_at');
                foreach ($datesHistory as $item) {
                    $valuesHistory[] = DB::table('users_cash')
                        ->where(['user_id' => Auth::user()->id])
                        ->whereDate('created_at', '=', $item->created_at)
                        ->avg('sum');
                }
            }
        }
        $values = self::wrapValuesHistory($valuesHistory);
        return ['dates'=>$datesHistory,'values'=>$values];
    }


}
