<?php

namespace App\Http\Controllers;

use DB;

class RegionController extends Controller
{
    public function statistics($sigla){
        $region = DB::table('region_datas')->where('codice_regione',$sigla)->first();
        $datas = DB::table('region_datas')->where('codice_regione',$sigla)->orderBy('data')->get();

        return view('regions.statistics',['region' => $region, 'datas' => $datas]);
    }
}
