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

    public function statistics($sigla){
        $stato = DB::table('nation_datas')->where('stato',$sigla)->first();
        $datas = DB::table('nation_datas')->where('stato',$sigla)->orderBy('data','DESC')->get();

        return view('nations.statistics',['stato' => $stato, 'datas' => $datas]);
    }
}