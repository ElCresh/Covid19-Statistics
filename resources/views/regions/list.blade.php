@extends('layouts.app')

{{---------------Content---------------}}
@section('content')

<div class="title text-center mb-3">
    {{ __('sidebar.regions') }}:
</div>

<div class="row">
    @foreach(DB::table('region_datas')->groupBy('codice_regione')->orderBy('denominazione_regione')->get() as $region)
        @php
            $data = DB::table('region_datas')->where('codice_regione',$region->codice_regione)->orderBy('data','DESC')->first();
        @endphp
        <div class="col-sm-4">
            <div class="text-center">
                <h4>{{ $region->denominazione_regione }}</h4>
            </div>
    
            @if ($data->variazione_totale_positivi < 0)
                <div class="small-box bg-success">
            @elseif ($data->variazione_totale_positivi > 0)
                <div class="small-box bg-danger">
            @else
                <div class="small-box bg-secondary">
            @endif
                <div class="inner">
                    <h3>{{ $data->totale_attualmente_positivi }}</h3>
                    <p>
                        Casi attuali<br /><br />
                        {{ $data->variazione_totale_positivi }} variazione casi<br />
                        {{ $data->totale_casi }} totale casi
                    </p>
                </div>
                <div class="icon">
                    @if ($data->variazione_totale_positivi < 0)
                        <i class="fas fa-chevron-down""></i>
                    @elseif ($data->variazione_totale_positivi > 0)
                        <i class="fas fa-chevron-up""></i>
                    @else
                        <i class="fas fa-minus"></i>
                    @endif
                </div>
                <a href="{{ route('region.statistics', ['sigla' => $region->codice_regione]) }}" class="small-box-footer">
                    {{ __('sidebar.more_info') }} <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    @endforeach
</div>
@endsection