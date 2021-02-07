<?php

namespace App\Http\Controllers;

use DB;
use App\ItalyData;
use App\NationData;

use App\Tables\ItalyDataTable;
use App\Tables\NationDataTable;

class NationController extends Controller
{
    public function statistics_italy(){
        $sigla = "Italy";

        $stato = ItalyData::first();
        $data = ItalyData::orderBy('data','DESC')->get();

        return view('nations.statistics_italy',['stato' => $stato, 'data' => $data, 'table' => (new ItalyDataTable($sigla))->setup()]);
    }

    public function provinces($sigla){
        $provinces = NationData::where('country_region',$sigla)->groupBy('province_state')->orderBy('province_state')->get();

        if($provinces->count() > 0){
            if($provinces->count() == 1){
                if ($provinces[0]->province_state != ''){
                    return redirect(route('nation.province.statistics', ['sigla' => $provinces[0]->country_region, 'province' => $provinces[0]->province_state]));
                }else{
                    return redirect(route('nation.province.statistics', ['sigla' => $provinces[0]->country_region, 'province' => '_']));
                }

            }else{
                return view('nations.provinces',['provinces' => $provinces]);
            }
        }else{
            return abort('404',"Not found");
        }
    }

    public function statistics($sigla){
        $stato = NationData::where('country_region',$sigla)->orderBy('last_update','DESC')->first();
        $datas = NationData::where('country_region',$sigla)->orderBy('last_update','DESC')->get();

        if(!is_null($stato) && !is_null($datas)){
            return view('nations.statistics',['stato' => $stato, 'datas' => $datas]);
        }else{
            return abort('404',"Not found");
        }
    }

    public function province_statistics($sigla,$province){
        if($province == '_'){
            $stato = NationData::where('country_region',$sigla)->where('province_state','')->orderBy('last_update','DESC')->first();
            $datas = NationData::where('country_region',$sigla)->where('province_state','')->orderBy('last_update','DESC')->get();
        }else{
            $stato = NationData::where('province_state',$province)->orderBy('last_update','DESC')->first();
            $datas = NationData::where('province_state',$province)->orderBy('last_update','DESC')->get();
        }

        if(!is_null($stato) && !is_null($datas)){
            return view('nations.statistics',['stato' => $stato, 'datas' => $datas, 'table' => (new NationDataTable($sigla, $province))->setup()]);
        }else{
            return abort('404',"Not found");
        }


    }
}