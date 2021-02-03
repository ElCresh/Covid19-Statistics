@extends('layouts.dashboard')

{{---------------Content---------------}}
@section('content')

<div class="title text-center m-b-md d-none d-sm-block mb-2">
    <div class="row">
        <div class="col-sm-4">
            <img class="img-fluid" src="{{ asset('imgs/logo-notiosoft.png') }}" />
        </div>
        <div class="col-sm-8 mt-3">
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
        <div class="col-sm-4">
            <img class="img-fluid" src="{{ asset('imgs/logo-notiosoft.png') }}" />
        </div>
        <div class="col-sm-8 mt-3 mb-3">
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
            <h3 class="no-margin">Italia</h3>
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

        <div class="card">
            @if ($value < 0)
                <div class="card-header card-header-icon card-header-success">
                    <div class="card-icon">
                        <i class="material-icons">expand_more</i>
                    </div>
                </div>
            @elseif ($value > 0)
                <div class="card-header card-header-icon card-header-danger">
                    <div class="card-icon">
                        <i class="material-icons">expand_less</i>
                    </div>
                </div>
            @else
                <div class="card-header card-header-icon card-header-secondary">
                    <div class="card-icon">
                        <i class="material-icons">remove</i>
                    </div>
                </div>
            @endif
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h3 class="no-margin">{{ $total_positive }}</h3>
                        Casi attuali
                    </div>
                    <div class="col">
                        <b>{{ $value }}</b> variazione casi<br />
                        <b>{{ $total_case }}</b> totale casi
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">arrow_right_alt</i>
                    <a href="{{ route('nation.statistics', ['sigla' => 'Italy']) }}">
                        {{ __('sidebar.more_info') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- 
        = Other Nations Dashboard =
        
        Array Composition:
        [0] => Province (if needed)
        [1] => Nation
        [2] => Direct access to global data
    --}}
    @foreach ([['','San Marino', true],['','Spain', true],['','Germany', true],['','France', true],['','Portugal', false],['','United Kingdom', true],['','US', true],['','Russia', true]] as $sigla)
        <div class="col-sm-4"> 
            <div class="mb-3">
                <div class="text-center">
                    @if ($sigla[0] != '')
                        <h3 class="no-margin">{{ $sigla[0] }} ({{ $sigla[1] }})</h3>
                    @else
                        <h3 class="no-margin">{{ $sigla[1] }}</h3>
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
                        $active_case = "?";
                    }
                    //--
                @endphp

                <div class="card">
                    @if ($value < 0)
                        <div class="card-header card-header-icon card-header-success">
                            <div class="card-icon">
                                <i class="material-icons">expand_more</i>
                            </div>
                        </div>
                    @elseif ($value > 0)
                        <div class="card-header card-header-icon card-header-danger">
                            <div class="card-icon">
                                <i class="material-icons">expand_less</i>
                            </div>
                        </div>
                    @else
                        <div class="card-header card-header-icon card-header-secondary">
                            <div class="card-icon">
                                <i class="material-icons">remove</i>
                            </div>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="no-margin">{{ $total_positive }}</h3>
                                Casi attuali*
                            </div>
                            <div class="col">
                                <b>{{ $value }}</b> variazione casi*<br />
                                <b>{{ $total_case }}</b> totale casi
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">arrow_right_alt</i>
                            @if($sigla[2])
                                <a href="{{ route('nation.province.statistics', ['sigla' => $sigla[1], 'province' => '_']) }}">
                                    {{ __('sidebar.more_info') }}
                                </a>
                            @else
                                <a href="{{ route('nation.provinces', ['sigla' => $sigla[1]]) }}">
                                    {{ __('sidebar.more_info') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="text-center mb-3">
    <b>*</b> Dati calcolati automaticamente in base ai dati forniti <br />
    Dati provenienti dalla Protezione Civile per l'Italia, ISS per Repubblica di San Marino e Johns Hopkins CSSE per il resto del mondo.
</div>

@endsection