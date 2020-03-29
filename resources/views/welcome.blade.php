@extends('layouts.app')

{{---------------Content---------------}}
@section('content')

<div class="title m-b-md text-center">
    {{ config('app.name')}}
</div>

<div class="text-center mb-5">
    <div class="spinner-grow spinner-bing text-success" role="status">
        <span class="sr-only">GREEN</span>
    </div>
    <div class="spinner-grow spinner-bing text-light ml-2" role="status">
        <span class="sr-only">WHITE</span>
    </div>
    <div class="spinner-grow spinner-bing text-danger ml-2" role="status">
        <span class="sr-only">RED</span>
    </div>
</div>

<div class="links text-center">
    <a href="{{route('nation.statistics',['sigla' => 'ita'])}}">Nazione</a>
    <a href="{{route('regions')}}">Regioni</a>
    <a href="{{route('provinces')}}">Province</a>
    <a href="https://github.com/ElCresh/Covid19-Statistics">GitHub</a>
</div>

@endsection