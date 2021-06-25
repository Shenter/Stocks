<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminMoneySeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_money')->insert([
            'id' => null,
            'created_at'=>date('Y-m-d H:i:s') ,
            'updated_at'=>date('Y-m-d H:i:s') ,
            'sum'=>0,

        ]);
    }
}
