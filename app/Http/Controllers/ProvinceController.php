<?php

namespace App\Http\Controllers;

use DB;

class ProvinceController extends Controller
{
    public function statistics($sigla){
        $province = DB::table('province_datas')->where('sigla_provincia',$sigla)->first();
        $datas = DB::table('province_datas')->where('sigla_provincia',$sigla)->orderBy('data')->get();

        return view('provinces.statistics',['province' => $province, 'datas' => $datas]);
    }
}
