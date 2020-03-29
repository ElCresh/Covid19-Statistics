
@extends('layouts.app')

{{---------------Content---------------}}
@section('content')

@php
    use Carbon\Carbon;
@endphp

<script>
    var casi_totali = [];
    var differenza_giorno_precedente = [];
    var labels = [];
</script>

<div class="row">
    <div class="col-sm-7 mb-4">
        <div class="title">
            {{ $province->denominazione_provincia }} ({{ $province->sigla_provincia }})
        </div>
    </div>
    <div class="col-sm-5">
        <div class="card text-white bg-dark mb-3 float-right">
            <div class="card-body">
                <h5 class="card-title">Dettagli:</h5>
                <p class="card-text text-left links">
                    <b>Denominazione regione:</b> {{ $province->denominazione_regione }} <br />
                    <b>Denominazione provincia:</b> {{ $province->denominazione_provincia }} <br />
                    <b>Sigla provincia:</b> {{ $province->sigla_provincia }} <br />
                    <b>Coordinate:</b> <a target="_blank" href="https://maps.google.it/?q={{ $province->lat }},{{ $province->long }}">{{ $province->lat }},{{ $province->long }}</a> <br />
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <table class="table text-center">
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

                        $date = new Carbon($data->data);
                    @endphp
                    <tr>
                        <th scope="row">{{ $date->toDateString() }}</th>
                        <td>{{ $data->totale_casi }}</td>
                        <td>{{ $diff }}</td>
                    </tr>
                    <script>
                        differenza_giorno_precedente.push({{ $diff }});
                        casi_totali.push({{ $data->totale_casi }});
                        labels.push('{{ $date->toDateString() }}');
                    </script>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-8">
        <canvas id="casiTotaliGrafico" width="400" height="200"></canvas>
        <canvas id="differenzaGiorPrecGrafico" width="400" height="200"></canvas>
    </div>
</div>

<script>
    $(document).ready(() => {
        var casiTotaliGrafico = document.getElementById('casiTotaliGrafico');
        var myLineChart = new Chart(casiTotaliGrafico, {
            type: 'line',
            fill: false,
            data:{
                labels: labels,
                datasets: [{
                    backgroundColor: 'rgb(54, 162, 235)',
                    borderColor: 'rgb(54, 162, 235)',
                    fill: false,
                    data: casi_totali,
                }]
            },
            options: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: 'Casi totali'
                },
            }
        });

        var differenzaGiorPrecGrafico = document.getElementById('differenzaGiorPrecGrafico');
        var myLineChart = new Chart(differenzaGiorPrecGrafico, {
            type: 'line',
            fill: false,
            data:{
                labels: labels,
                datasets: [{
                    backgroundColor: 'rgb(255, 159, 64)',
                    borderColor: 'rgb(255, 159, 64)',
                    fill: false,
                    data: differenza_giorno_precedente,
                }]
            },
            options: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: 'Differenza giorno precedente'
                },
            }
        });
    });
</script>

@endsection