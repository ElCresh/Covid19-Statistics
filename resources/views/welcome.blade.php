@extends('layouts.app')

{{---------------Content---------------}}
@section('content')

<div class="title m-b-md text-center d-none d-sm-block">
    {{ config('app.name')}}
</div>

<div class="h2 m-b-md text-center d-block d-sm-none">
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
    <a href="{{route('nations')}}">{{__('sidebar.nations')}}</a>
    <a href="{{route('regions')}}">{{__('sidebar.regions')}}</a>
    <a href="{{route('provinces')}}">{{__('sidebar.provinces')}}</a>
    <a href="https://github.com/ElCresh/Covid19-Statistics">GitHub</a>
</div>

@endsection