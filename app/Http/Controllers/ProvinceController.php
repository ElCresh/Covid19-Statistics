<?php

namespace App\Http\Controllers;

use DB;

class ProvinceController extends Controller
{
    public function statistics($sigla){
        $province = DB::table('province_datas')->where('sigla_provincia',$sigla)->first();
        $datas = DB::table('province_datas')->where('sigla_provincia',$sigla)->orderBy('data','DESC')->get();

        if(!is_null($province) && !is_null($datas)){
            return view('provinces.statistics',['province' => $province, 'datas' => $datas]);
        }else{
            return abort('404',"Not found");
        }
    }
}
