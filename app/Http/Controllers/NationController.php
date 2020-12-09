<?php

namespace App\Http\Controllers;

use DB;

class NationController extends Controller
{
    public function statistics_italy(){
        $sigla = "ita";
        $stato = DB::table('italy_datas')->where('stato',$sigla)->first();
        $datas = DB::table('italy_datas')->where('stato',$sigla)->orderBy('data','DESC')->get();

        return view('nations.statistics_italy',['stato' => $stato, 'datas' => $datas]);
    }

    public function statistics_smr(){
        $stato = null;
        $datas = DB::table('rsm_datas')->orderBy('data','DESC')->get();

        return view('nations.statistics_smr',['stato' => $stato, 'datas' => $datas]);
    }

    public function provinces($sigla){
        $provinces = DB::table('nation_datas')->where('country_region',$sigla)->groupBy('province_state')->orderBy('province_state')->get();

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
        $stato = DB::table('nation_datas')->where('country_region',$sigla)->orderBy('last_update','DESC')->first();
        $datas = DB::table('nation_datas')->where('country_region',$sigla)->orderBy('last_update','DESC')->get();

        if(!is_null($stato) && !is_null($datas)){
            return view('nations.statistics',['stato' => $stato, 'datas' => $datas]);
        }else{
            return abort('404',"Not found");
        }
    }

    public function province_statistics($sigla,$province){
        if($province == '_'){
            $stato = DB::table('nation_datas')->where('country_region',$sigla)->where('province_state','')->orderBy('last_update','DESC')->first();
            $datas = DB::table('nation_datas')->where('country_region',$sigla)->where('province_state','')->orderBy('last_update','DESC')->get();
        }else{
            $stato = DB::table('nation_datas')->where('province_state',$province)->orderBy('last_update','DESC')->first();
            $datas = DB::table('nation_datas')->where('province_state',$province)->orderBy('last_update','DESC')->get();
        }

        if(!is_null($stato) && !is_null($datas)){
            return view('nations.statistics',['stato' => $stato, 'datas' => $datas]);
        }else{
            return abort('404',"Not found");
        }


    }
}