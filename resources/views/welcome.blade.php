@extends('layouts.app')

{{---------------Content---------------}}
@section('content')

<div class="title text-center m-b-md d-none d-sm-block">
    <div class="row">
        <img class="col-sm-4" src="{{ asset('imgs/logo-notiosoft.png') }}" />
        <div class="col-sm-8">
            <span class="align-middle">
                {{ config('app.name')}}
            </span>
        </div>
    </div>
</div>

<div class="h1 m-b-md text-center d-block d-sm-none">
    <div class="row">
        <img class="col-sm-4 mb-3" src="{{ asset('imgs/logo-notiosoft.png') }}" />
        <div class="col-sm-8">
            {{ config('app.name')}}
        </div>
    </div>
</div>

<div class="text-center mb-4">
    <div class="spinner-grow spinner-bing text-success" role="status">
        <span class="sr-only">GREEN</span>
    </div>
    <div class="spinner-grow spinner-bing text-light ml-2" role="status">
        <span class="sr-only">WHITE</span>
    </div>
    <div class="spinner-grow spinner-bing text-danger ml-2" role="status">
        <span class="sr-only">RED</span>
    </div>
</div>

<div class="row">
    {{-- Italy Dashboard --}}
    <div class="col-sm-4">
        <div class="text-center">
            <h4>Italia</h4>
        </div>
        @php
            $datas = DB::table('italy_datas')->where('stato','ita')->orderBy('data','DESC')->get();            
            
            if($datas->count() != 0){
                // diff lookahead for progression
                if($datas->count() < 2){
                    $diff_lookahead = $datas[0]->nuovi_attualmente_positivi;
                    $diff = $datas[0]->nuovi_attualmente_positivi;
                    $value = $datas[0]->nuovi_attualmente_positivi;
                }else{
                    $diff_lookahead = $datas[1]->nuovi_attualmente_positivi;
                    $diff = $datas[0]->nuovi_attualmente_positivi;
                    $value = $datas[0]->nuovi_attualmente_positivi;
                }

                $total_positive = $datas[0]->totale_attualmente_positivi;
            }else{
                $diff_lookahead = 0;
                $diff = 0;
                $value = "?";

                $total_positive = "?";
            }
            //--
        @endphp

        @if ($diff_lookahead > $diff)
            <div class="small-box bg-success">
        @elseif ($diff_lookahead < $diff)
            <div class="small-box bg-danger">
        @else
            <div class="small-box bg-secondary">
        @endif
            <div class="inner">
                <h3>{{ $total_positive }}</h3>
                <p>
                    Casi attuali<br />
                    {{ $value }} nuovi casi
                </p>
            </div>
            <div class="icon">
                @if ($diff_lookahead > $diff)
                    <i class="fas fa-chevron-down""></i>
                @elseif ($diff_lookahead < $diff)
                    <i class="fas fa-chevron-up""></i>
                @else
                    <i class="fas fa-minus"></i>
                @endif
            </div>
            <a href="{{ route('nation.statistics', ['sigla' => 'Italy']) }}" class="small-box-footer">
                {{ __('sidebar.more_info') }} <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    {{-- Rep. San Marino Dashboard --}}
    <div class="col-sm-4">
        <div class="text-center">
            <h4>Rep. di San Marino</h4>
        </div>
        @php
            $datas = DB::table('rsm_datas')->orderBy('data','DESC')->get();

            if($datas->count() != 0){
                // diff lookahead for progression
                if($datas->count() < 2){
                    $diff_lookahead = $datas[0]->nuovi_casi;
                    $diff = $datas[0]->nuovi_casi;
                    $value = $datas[0]->nuovi_casi;
                }else{
                    $diff_lookahead = $datas[1]->nuovi_casi;
                    $diff = $datas[0]->nuovi_casi;
                    $value = $datas[0]->nuovi_casi;
                }

                $total_positive = $datas[0]->malati;
            }else{
                $diff_lookahead = 0;
                $diff = 0;
                $value = "?";

                $total_positive = "?";
            }
            //--
        @endphp

        @if ($diff_lookahead > $diff)
            <div class="small-box bg-success">
        @elseif ($diff_lookahead < $diff)
            <div class="small-box bg-danger">
        @else
            <div class="small-box bg-secondary">
        @endif
            <div class="inner">
                <h3>{{ $total_positive }}</h3>
                <p>
                    Casi attuali<br />
                    {{ $value }} nuovi casi
                </p>
            </div>
            <div class="icon">
                @if ($diff_lookahead > $diff)
                    <i class="fas fa-chevron-down""></i>
                @elseif ($diff_lookahead < $diff)
                    <i class="fas fa-chevron-up""></i>
                @else
                    <i class="fas fa-minus"></i>
                @endif
            </div>
            <a href="{{ route('nation.statistics', ['sigla' => 'San Marino']) }}" class="small-box-footer">
                {{ __('sidebar.more_info') }} <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    {{-- 
        = Other Nations Dashboard =
        
        Array Composition:
        [0] => Province (if needed)
        [1] => Nation
        [2] => Province id for route
    --}}
    @foreach ([['Hubei','China','Hubei'],['','Germany',''],['','Spain',''],['','France','_']] as $sigla)
        <div class="col-sm-4"> 
            <div class="mb-3">
                <div class="text-center">
                    @if ($sigla[0] != '')
                        <h4>{{ $sigla[0] }} ({{ $sigla[1] }})</h4>
                    @else
                        <h4>{{ $sigla[1] }}</h4>
                    @endif
                </div>
                @php
                    $datas = DB::table('nation_datas')->where('province_state',$sigla[0])->where('country_region',$sigla[1])->orderBy('last_update','DESC')->get();
                    
                    if($datas->count() != 0){
                        // diff lookahead for progression
                        if($datas->count() > 2){
                            $prec_giorno = $datas[1]->confirmed;
                            $diff = $datas[0]->confirmed - $prec_giorno;

                            // diff lookahead for progression
                            $prec_giorno_ahead = $datas[2]->confirmed;
                            $diff_lookahead = $prec_giorno - $prec_giorno_ahead;
                            
                            $value = $diff;
                        }else{
                            $prec_giorno = $datas[1]->confirmed;
                            $diff = $datas[0]->confirmed - $prec_giorno;
                            $diff_lookahead = $diff;
                            $value = $datas[0]->deaths;
                        }

                        $total_positive = $datas[0]->confirmed;
                    }else{
                        $diff_lookahead = 0;
                        $diff = 0;
                        $value = "?";

                        $total_positive = "?";
                    }
                    //--

                    if($sigla[2] != ''){
                        $url = route('nation.province.statistics', ['sigla' => $sigla[1], 'province' => $sigla[2]]);
                    }else{
                        $url = route('nation.statistics', ['sigla' => $sigla[1]]);
                    }
                @endphp

                @if ($diff_lookahead > $diff)
                    <div class="small-box bg-success">
                @elseif ($diff_lookahead < $diff)
                    <div class="small-box bg-danger">
                @else
                    <div class="small-box bg-secondary">
                @endif
                    <div class="inner">
                        <h3>{{ $total_positive }}</h3>
                        <p>
                            Casi totali<br />
                            {{ $diff }} nuovi casi
                        </p>
                    </div>
                    <div class="icon">
                        @if ($diff_lookahead > $diff)
                            <i class="fas fa-chevron-down""></i>
                        @elseif ($diff_lookahead < $diff)
                            <i class="fas fa-chevron-up""></i>
                        @else
                            <i class="fas fa-minus"></i>
                        @endif
                    </div>
                    <a href="{{ $url }}" class="small-box-footer">
                        {{ __('sidebar.more_info') }} <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="text-center mb-3">
    Dati provenienti dalla Protezione Civile per l'Italia, ISS per Repubblica di San Marino e Johns Hopkins CSSE per il resto del mondo.
</div>

@endsection