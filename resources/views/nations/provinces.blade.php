@extends('layouts.dashboard')

{{---------------Content---------------}}
@section('content')

<div class="h3 text-center">
    {{ __('sidebar.provinces') }}:
</div>

<div class="row">
    @foreach($provinces as $province)
        <div class="col-sm-4"> 
            <div class="mb-3">
                <div class="text-center">
                    @if ($province->province_state != '')
                        <h3 class="no-margin">{{ $province->province_state }} ({{ $province->country_region }})</h3>
                    @else
                        <h3 class="no-margin">{{ $province->country_region }}</h3>
                    @endif
                </div>
                @php
                    $datas = DB::table('nation_datas')->where('province_state',$province->province_state)->where('country_region',$province->country_region)->orderBy('last_update','DESC')->get();
                    
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
                                <b>{{ $active_case }}</b> totale casi
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">arrow_right_alt</i>
                            @if ($province->province_state != '')
                                <a href="{{ route('nation.province.statistics', ['sigla' => $province->country_region, 'province' => $province->province_state]) }}">
                            @else
                                <a href="{{ route('nation.province.statistics', ['sigla' => $province->country_region, 'province' => '_']) }}">
                            @endif
                                {{ __('sidebar.more_info') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection