@extends('layouts.app')

{{---------------Content---------------}}
@section('content')

<div class="title text-center">
    Nazioni:
</div>

<div class="text-center links">
    @foreach(DB::table('nation_datas')->groupBy('countryterritoryCode')->get() as $nation)
        @if ($nation->countryterritoryCode != '')        
            <a href="{{ route('nation.statistics', ['sigla' => $nation->countryterritoryCode]) }}">{{ str_replace('_',' ',$nation->countriesAndTerritories) }} ({{ $nation->countryterritoryCode }})</a> <br />
        @endif
    @endforeach
</div>

@endsection