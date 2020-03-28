@extends('layouts.app')

{{---------------Content---------------}}
@section('content')

<div class="title">
    {{ config('app.name')}} <br />
</div>
<div class="h1">
    Regioni:
</div>

<div class="links">
    @foreach(DB::table('region_datas')->groupBy('codice_regione')->orderBy('denominazione_regione')->get() as $region)
        <a href="{{ route('region.statistics', ['sigla' => $region->codice_regione]) }}">{{ $region->denominazione_regione }}</a> <br />
    @endforeach
</div>

@endsection