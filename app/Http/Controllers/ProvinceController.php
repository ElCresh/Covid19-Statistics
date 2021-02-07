<?php

namespace App\Http\Controllers;

use DB;
use App\ProvinceData;

use App\Tables\ProvinceDataTable;

class ProvinceController extends Controller
{
    public function statistics($sigla){
        $province = ProvinceData::where('sigla_provincia',$sigla)->first();
        $datas = ProvinceData::where('sigla_provincia',$sigla)->orderBy('data','DESC')->get();

        if(!is_null($province) && !is_null($datas)){
            return view('provinces.statistics',['province' => $province, 'datas' => $datas, 'table' => (new ProvinceDataTable($sigla))->setup()]);
        }else{
            return abort('404',"Not found");
        }
    }
}
