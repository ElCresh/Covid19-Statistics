@extends('layouts.dashboard')

{{---------------Content---------------}}
@section('content')

<div class="h3 text-center">
    {{ __('sidebar.provinces') }}:
</div>

<div class="text-center links">
    @foreach(DB::table('province_datas')->groupBy('sigla_provincia')->get() as $province)
        @if($province->sigla_provincia != '')
            <a href="{{ route('province.statistics', ['sigla' => $province->sigla_provincia]) }}">{{ $province->denominazione_provincia }} ({{ $province->sigla_provincia }})</a> <br />
        @endif
    @endforeach
</div>

@endsection