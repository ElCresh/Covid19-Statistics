@extends('layouts.app')

{{---------------Content---------------}}
@section('content')

<div class="title text-center m-b-md d-none d-sm-block">
    <div class="row">
        <div class="col-sm-4">
            <img class="img-fluid" src="{{ asset('imgs/logo-notiosoft.png') }}" />
        </div>
        <div class="col-sm-8">
            <span class="align-middle">
                {{ config('app.name')}}
            </span>
            <br />
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
    </div>
</div>

<div class="h1 m-b-md text-center d-block d-sm-none">
    <div class="row">
        <div class="col-sm-4 mb-3">
            <img class="img-fluid" src="{{ asset('imgs/logo-notiosoft.png') }}" />
        </div>
        <div class="col-sm-8">
            {{ config('app.name')}}
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
                $value = $datas[0]->variazione_totale_positivi;
                $total_positive = $datas[0]->totale_attualmente_positivi;
                $total_case = $datas[0]->totale_casi;
            }else{
                $value = "?";
                $total_positive = "?";
                $total_case = "?";
            }
            //--
        @endphp

        @if ($value < 0)
            <div class="small-box bg-success">
        @elseif ($value > 0)
            <div class="small-box bg-danger">
        @else
            <div class="small-box bg-secondary">
        @endif
            <div class="inner">
                <h3>{{ $total_positive }}</h3>
                <p>
                    Casi attuali<br /><br />
                    {{ $value }} variazione casi<br />
                    {{ $total_case }} totale casi
                </p>
            </div>
            <div class="icon">
                @if ($value < 0)
                    <i class="fas fa-chevron-down""></i>
                @elseif ($value > 0)
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
                $value = $datas[0]->nuovi_malati;
                $total_positive = $datas[0]->malati;
                $total_case = $datas[0]->totale_casi;
            }else{
                $value = "?";
                $total_positive = "?";
                $total_case = "?";
            }
            //--
        @endphp

        @if ($value < 0)
            <div class="small-box bg-success">
        @elseif ($value > 0)
            <div class="small-box bg-danger">
        @else
            <div class="small-box bg-secondary">
        @endif
            <div class="inner">
                <h3>{{ $total_positive }}</h3>
                <p>
                    Casi attuali<br /><br />
                    {{ $value }} variazione casi<br />
                    {{ $total_case }} totale casi
                </p>
            </div>
            <div class="icon">
                @if ($value < 0)
                    <i class="fas fa-chevron-down""></i>
                @elseif ($value > 0)
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
    --}}
    @foreach ([['Hubei','China'],['','Germany'],['','Spain'],['','France']] as $sigla)
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
                        if($datas->count() > 1){
                            $active_case_prev = ($datas[1]->confirmed - ($datas[1]->recovered + $datas[1]->deaths));
                        }else{
                            $active_case_prev = 0;
                        }
                        
                        $active_case = ($datas[0]->confirmed - ($datas[0]->recovered + $datas[0]->deaths));

                        $value = $active_case - $active_case_prev;
                        $total_positive = $datas[0]->confirmed;
                    }else{
                        $value = "?";
                        $total_positive = "?";
                        $total_case = "?";
                    }
                    //--
                @endphp

                @if ($value < 0)
                    <div class="small-box bg-success">
                @elseif ($value > 0)
                    <div class="small-box bg-danger">
                @else
                    <div class="small-box bg-secondary">
                @endif
                    <div class="inner">
                        <h3>{{ $active_case }}</h3>
                        <p>
                            Casi attuali*<br /><br />
                            {{ $value }} variazione casi*<br />
                            {{ $total_positive }} totale casi
                        </p>
                    </div>
                    <div class="icon">
                        @if ($value < 0)
                            <i class="fas fa-chevron-down""></i>
                        @elseif ($value > 0)
                            <i class="fas fa-chevron-up""></i>
                        @else
                            <i class="fas fa-minus"></i>
                        @endif
                    </div>
                    <a href="{{ route('nation.provinces', ['sigla' => $sigla[1]]) }}" class="small-box-footer">
                        {{ __('sidebar.more_info') }} <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="text-center mb-3">
    <b>*</b> "{{ __('statistics.active_case') }}" e "Variazione del totale positivi" calcolati automaticamente in base ai dati forniti <br />
    Dati provenienti dalla Protezione Civile per l'Italia, ISS per Repubblica di San Marino e Johns Hopkins CSSE per il resto del mondo.
</div>

@endsection