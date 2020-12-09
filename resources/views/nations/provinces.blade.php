@extends('layouts.app')

{{---------------Content---------------}}
@section('content')

<div class="title text-center">
    {{ __('sidebar.provinces') }}:
</div>

<div class="row">
    @foreach($provinces as $province)
        <div class="col-sm-4"> 
            <div class="mb-3">
                <div class="text-center">
                    @if ($province->province_state != '')
                        <h4>{{ $province->province_state }} ({{ $province->country_region }})</h4>
                    @else
                        <h4>{{ $province->country_region }}</h4>
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
                    
                    @if ($province->province_state != '')
                        <a href="{{ route('nation.province.statistics', ['sigla' => $province->country_region, 'province' => $province->province_state]) }}" class="small-box-footer">
                    @else
                        <a href="{{ route('nation.province.statistics', ['sigla' => $province->country_region, 'province' => '_']) }}" class="small-box-footer">
                    @endif
                            {{ __('sidebar.more_info') }} <i class="fas fa-arrow-circle-right"></i>
                        </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection