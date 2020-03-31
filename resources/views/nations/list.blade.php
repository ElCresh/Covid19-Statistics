@extends('layouts.app')

{{---------------Content---------------}}
@section('content')

<div class="title text-center">
    {{ __('sidebar.nations') }}:
</div>

<div class="text-center links">
    @foreach(DB::table('nation_datas')->groupBy('country_region')->orderBy('country_region')->get() as $nation)
        @if ($nation->country_region != '')
            @if ($nation->province_state != '')
                <a href="{{ route('nation.provinces', ['sigla' => $nation->country_region]) }}">{{ $nation->country_region }}</a> <br />
            @else
                <a href="{{ route('nation.statistics', ['sigla' => $nation->country_region]) }}">{{ $nation->country_region }}</a> <br />
            @endif
        @endif
    @endforeach
</div>

@endsection