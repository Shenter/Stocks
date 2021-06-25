<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StocksHistoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stock_histories')->insert([
            'id' => null,
            'created_at'=>date('Y-m-d H:i:s') ,
            'updated_at'=>date('Y-m-d H:i:s') ,
            'stock_id' =>1,
            'sum'=>10000,

        ]);
        DB::table('stock_histories')->insert([
            'id' => null,
            'created_at'=>date('Y-m-d H:i:s') ,
            'updated_at'=>date('Y-m-d H:i:s') ,
            'stock_id' =>2,
            'sum'=>20000,

        ]);
        DB::table('stock_histories')->insert([
            'id' => null,
            'created_at'=>date('Y-m-d H:i:s') ,
            'updated_at'=>date('Y-m-d H:i:s') ,
            'stock_id' =>3,
            'sum'=>1000,

        ]);
        DB::table('stock_histories')->insert([
            'id' => null,
            'created_at'=>date('Y-m-d H:i:s') ,
            'updated_at'=>date('Y-m-d H:i:s') ,
            'stock_id' =>4,
            'sum'=>5000,
        ]);

sleep(2);
        DB::table('stock_histories')->insert([
            'id' => null,
            'created_at'=>date('Y-m-d H:i:s') ,
            'updated_at'=>date('Y-m-d H:i:s') ,
            'stock_id' =>1,
            'sum'=>10100,

        ]);
        DB::table('stock_histories')->insert([
            'id' => null,
            'created_at'=>date('Y-m-d H:i:s') ,
            'updated_at'=>date('Y-m-d H:i:s') ,
            'stock_id' =>2,
            'sum'=>20100,

        ]);
        DB::table('stock_histories')->insert([
            'id' => null,
            'created_at'=>date('Y-m-d H:i:s') ,
            'updated_at'=>date('Y-m-d H:i:s') ,
            'stock_id' =>3,
            'sum'=>1100,

        ]);
        DB::table('stock_histories')->insert([
            'id' => null,
            'created_at'=>date('Y-m-d H:i:s') ,
            'updated_at'=>date('Y-m-d H:i:s') ,
            'stock_id' =>4,
            'sum'=>5100,
        ]);


    }
}
