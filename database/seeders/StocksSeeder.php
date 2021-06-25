<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StocksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stocks')->insert([
            'id' => null,
            'name'=>'Акции шоколадной фабрики',
            'volatility'=>'1',
        ]);
        DB::table('stocks')->insert([
            'id' => null,
            'name'=>'Акции мармеладной фабрики',
            'volatility'=>'1',
        ]);
        DB::table('stocks')->insert([
            'id' => null,
            'name'=>'Акции весёлой фермы',
            'volatility'=>'1',
        ]);
        DB::table('stocks')->insert([
            'id' => null,
            'name'=>'Брусничные акции',
            'volatility'=>'1',
        ]);


    }
}
