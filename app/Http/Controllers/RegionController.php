<?php

namespace App\Http\Controllers;

use DB;
use App\RegionData;

use App\Tables\RegionDataTable;

class RegionController extends Controller
{
    public function statistics($sigla){
        $region = RegionData::where('codice_regione',$sigla)->first();
        $datas = RegionData::where('codice_regione',$sigla)->orderBy('data','DESC')->get();

        if(!is_null($region) && !is_null($datas)){
            return view('regions.statistics',['region' => $region, 'datas' => $datas, 'table' => (new RegionDataTable($sigla))->setup()]);
        }else{
            return abort('404',"Not found");
        }
    }
}
