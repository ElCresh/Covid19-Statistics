@extends('layouts.dashboard')

{{---------------Content---------------}}
@section('content')

<div class="h3 text-center mb-3">
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

            <div class="card">
                @if ($data->variazione_totale_positivi < 0)
                    <div class="card-header card-header-icon card-header-success">
                        <div class="card-icon">
                            <i class="material-icons">expand_more</i>
                        </div>
                    </div>
                @elseif ($data->variazione_totale_positivi > 0)
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
                            <h3 class="no-margin">{{ $data->totale_attualmente_positivi }}</h3>
                            Casi attuali
                        </div>
                        <div class="col">
                            <b>{{ $data->variazione_totale_positivi }}</b> variazione casi<br />
                            <b>{{ $data->totale_casi }}</b> totale casi
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">arrow_right_alt</i>
                        <a href="{{ route('region.statistics', ['sigla' => $region->codice_regione]) }}">
                            {{ __('sidebar.more_info') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection