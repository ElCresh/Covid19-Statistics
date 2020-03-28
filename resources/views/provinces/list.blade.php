@extends('layouts.app')

{{---------------Content---------------}}
@section('content')

<div class="title text-center">
    Province:
</div>

<div class="text-center links">
    @foreach(DB::table('province_datas')->groupBy('sigla_provincia')->get() as $province)
        @if($province->sigla_provincia != '')
            <a href="{{ route('province.statistics', ['sigla' => $province->sigla_provincia]) }}">{{ $province->denominazione_provincia }} ({{ $province->sigla_provincia }})</a> <br />
        @endif
    @endforeach
</div>

@endsection