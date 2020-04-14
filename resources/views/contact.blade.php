@extends('layouts.app')

{{---------------Content---------------}}
@section('content')

<div class="h1 m-b-md text-center">
    <div class="row">
        <div class="col-sm-4 mb-3">
            <img class="img-fluid" src="{{ asset('imgs/logo-notiosoft.png') }}" />
        </div>
        <div class="col-sm-8 my-auto">
            {{ __('sidebar.more_on_project') }}
        </div>
    </div>
</div>

@if($message = Session::get('success'))
    <div class="alert alert-success alert-block mr-5 ml-5">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>{{ $message }}</strong>
    </div>
@endif

<div class="card mr-5 ml-5">
    <div class="card-body">
        <h1 class="display-4">Contattaci</h1>
        <form action="{{ route('contact_submit') }}" method="post">
            @csrf
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Nome (*)</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Email (*)</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="message" class="col-sm-2 col-form-label">Messaggio (*)</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="message" name="message" required></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mb-2">Invia</button>
        </form>
    </div>
</div>

@endsection