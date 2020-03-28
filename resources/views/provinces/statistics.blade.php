
@extends('layouts.app')

{{---------------Content---------------}}
@section('content')

<div class="title">
    {{ config('app.name')}} <br />
</div>
<div class="h1">
    {{ $province->denominazione_provincia }} ({{ $province->sigla_provincia }})
</div>

<div class="row">
    <div class="col-md-4">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Data</th>
                    <th scope="col">Casi totali</th>
                    <th scope="col">Diff. prec. gior.</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $prec_giorno = 0;
                @endphp
                @foreach($datas as $data)
                    @php
                        $diff = $data->totale_casi - $prec_giorno;
                        $prec_giorno = $data->totale_casi;
                    @endphp
                    <tr>
                        <th scope="row">{{ $data->data }}</th>
                        <td>{{ $data->totale_casi }}</td>
                        <td>{{ $diff }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-8"></div>
</div>

@endsection