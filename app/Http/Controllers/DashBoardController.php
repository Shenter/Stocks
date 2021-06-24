<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use App\Http\Classes\DataPreparer;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\VarDumper\Cloner\Data;


class DashBoardController extends Controller

{
    public function show()
    {
        $data = DataPreparer::prepareUserCash();
        return view ('dashboard',['dates'=>$data['dates'],'values'=>$data['values']]);
    }







}
