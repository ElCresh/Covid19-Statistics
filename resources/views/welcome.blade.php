@extends('layouts.app')

{{---------------Content---------------}}
@section('content')

<div class="title m-b-md">
    {{ env('APP_NAME')}}
</div>

<div class="links">
    <a href="{{route('regions')}}">Regioni</a>
    <a href="{{route('provinces')}}">Province</a>
    <a href="https://github.com/ElCresh/Covid19-Statistics">GitHub</a>
</div>
{{--
    <div class="links">
        <a href="https://laravel.com/docs">Docs</a>
        <a href="https://laracasts.com">Laracasts</a>
        <a href="https://laravel-news.com">News</a>
        <a href="https://blog.laravel.com">Blog</a>
        <a href="https://nova.laravel.com">Nova</a>
        <a href="https://forge.laravel.com">Forge</a>
        <a href="https://vapor.laravel.com">Vapor</a>
        <a href="https://github.com/laravel/laravel">GitHub</a>
    </div>
--}}

@endsection