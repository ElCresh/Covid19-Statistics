@extends('layouts.dashboard')

{{---------------Content---------------}}
@section('content')

<div class="h3 text-center">
    {{ __('sidebar.nations') }}:
</div>

<div class="text-center links">
    @foreach(DB::table('nation_datas')->groupBy('country_region')->orderBy('country_region')->get() as $nation)
        @if ($nation->country_region != '')
            @if ($nation->country_region == 'Italy')
                <a href="{{ route('nation.statistics', ['sigla' => 'Italy']) }}">{{ $nation->country_region }}</a> <br />
            @elseif ($nation->country_region == 'San Marino')
                <a href="{{ route('nation.statistics', ['sigla' => 'San Marino']) }}">{{ $nation->country_region }}</a> <br />
            @else
                <a href="{{ route('nation.provinces', ['sigla' => $nation->country_region]) }}">{{ $nation->country_region }}</a> <br />
            @endif
        @endif
    @endforeach
</div>

@endsection