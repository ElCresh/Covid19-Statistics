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

    public function statistics($sigla){
        $stato = DB::table('nation_datas')->where('countryterritoryCode',$sigla)->first();
        $datas = DB::table('nation_datas')->where('countryterritoryCode',$sigla)->orderBy('year','DESC')->orderBy('month','DESC')->orderBy('day','DESC')->get();


        return view('nations.statistics',['stato' => $stato, 'datas' => $datas]);
    }
}