
@extends('layouts.app')

{{---------------Content---------------}}
@section('content')

<div class="title">
    {{ config('app.name')}} <br />
</div>
<div class="h1">
    {{ $region->denominazione_regione }}
</div>

<div class="row">
    <div class="col">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Data</th>
                    <th scope="col">Ricoverati con sintomi</th>
                    <th scope="col">Terapia intensiva</th>
                    <th scope="col">Totale ospedalizzati</th>
                    <th scope="col">Isolamento domicilare</th>
                    <th scope="col">Totale attualmente positivi</th>
                    <th scope="col">Nuovi casi positivi</th>
                    <th scope="col">Dimessi</th>
                    <th scope="col">Deceduti</th>
                    <th scope="col">Totale casi</th>
                    <th scope="col">Tamponi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                    <tr>
                        <th scope="row">{{ $data->data }}</th>
                        <td>{{ $data->ricoverati_con_sintomi }}</td>
                        <td>{{ $data->terapia_intensiva }}</td>
                        <td>{{ $data->totale_ospedalizzati }}</td>
                        <td>{{ $data->isolamento_domiciliare }}</td>
                        <td>{{ $data->totale_attualmente_positivi }}</td>
                        <td>{{ $data->nuovi_attualmente_positivi }}</td>
                        <td>{{ $data->dimessi_guariti }}</td>
                        <td>{{ $data->deceduti }}</td>
                        <td>{{ $data->totale_casi }}</td>
                        <td>{{ $data->tamponi }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection