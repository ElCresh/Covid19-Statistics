@extends('layouts.app')

{{---------------Content---------------}}
@section('content')

<div class="title text-center">
    {{ __('sidebar.provinces') }}:
</div>

<div class="text-center links">
    @foreach($provinces as $province)
        @if ($province->province_state != '')
            <a href="{{ route('nation.province.statistics', ['sigla' => $province->country_region, 'province' => $province->province_state]) }}">{{ $province->province_state }} ({{ $province->country_region }})</a> <br />
        @else
            <a href="{{ route('nation.province.statistics', ['sigla' => $province->country_region, 'province' => '_']) }}">{{ $province->country_region }}</a> <br />
        @endif
    @endforeach
</div>

@endsection