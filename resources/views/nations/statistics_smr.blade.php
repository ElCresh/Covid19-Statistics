
@extends('layouts.app')

{{---------------Content---------------}}
@section('content')

@php
    use Carbon\Carbon;
@endphp

<script>
    var differenza_giorno_precedente = [];
    var casi_positivi_attuali = [];
    var casi_dimessi_guariti = [];
    var casi_deceduti = [];
    var casi_totali = [];

    var casi_ospedalizzati = [];
    var casi_isolamento_domestico = [];

    var ospedali_ricoverati_sintomi = [];
    var ospedali_terapia_intensiva = [];

    var tamponi = [];

    var labels = [];
</script>

<div class="row">
    <div class="col">
        <div class="title">
            Repubblica di San Marino
        </div>
    </div>
</div>

<ul class="nav nav-tabs mb-2" id="tabs-menu" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="data-tab" data-toggle="tab" href="#data" role="tab" aria-controls="home" aria-selected="true">{{ __('statistics.data') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="graphs-tab" data-toggle="tab" href="#graphs" role="tab" aria-controls="profile" aria-selected="false">{{ __('statistics.graphs') }}</a>
    </li>
</ul>
<div class="tab-content mb-2" id="tabs-content">
    <div class="tab-pane fade show active" id="data" role="tabpanel" aria-labelledby="data-tab">
        <div class="row">
            <div class="col table-responsive">
                <table class="table text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Data</th>
                            <th scope="col">Totale ricoverati</th>
                            <th scope="col">Totale terapia intensiva</th>
                            <th scope="col">Totale degenze</th>
                            <th scope="col">Totale isolamento domicilare</th>
                            <th scope="col">Totale attualmente positivi</th>
                            <th scope="col">Nuovi casi positivi</th>
                            <th scope="col">Totale dimessi</th>
                            <th scope="col">Totale deceduti</th>
                            <th scope="col">Totale casi</th>
                            <th scope="col">Totale tamponi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datas as $index => $data)
                            @php
                                $date = new Carbon($data->data);

                                $diff = $data->nuovi_casi;

                                // diff lookahead for progression
                                if($index < ($datas->count() - 1)){
                                    $diff_lookahead = $datas[$index + 1]->nuovi_casi;
                                }else{
                                    $diff_lookahead = 0;
                                }
                                //--
                            @endphp
                            <tr>
                                <th scope="row">{{ $date->toDateString() }}</th>
                                <td>{{ $data->ricoverati }}</td>
                                <td>
                                    {{ $data->terapia_intensiva }}<br />
                                    <i class="text-primary small">{{ $data->terapia_intensiva_maschi }}</i>
                                    <i class="text-fuchsia small">{{ $data->terapia_intensiva_femmine }}</i>
                                </td>
                                <td>
                                    {{ $data->degenze_covid }}<br />
                                    <i class="text-primary small">{{ $data->degenze_covid_maschi }}</i>
                                    <i class="text-fuchsia small">{{ $data->degenze_covid_femmine }}</i>
                                </td>
                                <td>
                                    {{ $data->domicilio }}<br />
                                    <i class="text-primary small">{{ $data->domicilio_maschi }}</i>
                                    <i class="text-fuchsia small">{{ $data->domicilio_femmine }}</i>
                                </td>
                                <td>{{ $data->malati }}</td>
                                <td>
                                    @if ($diff_lookahead > $diff)
                                        <span class="badge badge-success">{{ $diff }}</span>
                                    @elseif ($diff_lookahead < $diff)
                                        <span class="badge badge-danger">{{ $diff }}</span>
                                    @else
                                        <span class="badge badge-secondary">{{ $diff }}</span>
                                    @endif
                                </td>
                                <td>{{ $data->guariti }}</td>
                                <td>
                                    {{ $data->decessi }}<br />
                                    <i class="text-primary small">{{ $data->decessi_maschi }}</i>
                                    <i class="text-fuchsia small">{{ $data->decessi_femmine }}</i>
                                </td>
                                <td>{{ $data->totale_casi }}</td>
                                <td>{{ $data->tamponi }}</td>
                            </tr>
                            <script>
                                // Saving data for charts
                                differenza_giorno_precedente.push({{ $data->nuovi_casi }});
                                casi_positivi_attuali.push({{ $data->malati }});
                                casi_dimessi_guariti.push({{ $data->guariti }});
                                casi_deceduti.push({{ $data->decessi }});
                                casi_totali.push({{ $data->totale_casi }});
        
                                casi_ospedalizzati.push({{ $data->degenze_covid }});
                                casi_isolamento_domestico.push({{ $data->domicilio }});
        
                                ospedali_ricoverati_sintomi.push({{ $data->ricoverati }});
                                ospedali_terapia_intensiva.push({{ $data->terapia_intensiva }});
        
                                tamponi.push({{ $data->tamponi }});
        
                                labels.push('{{ $date->toDateString() }}');
                            </script>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="graphs" role="tabpanel" aria-labelledby="graphs-tab">
        <div class="row">
            <div class="col-sm-6">
                <canvas id="casiTotaliGrafico" width="400" height="200"></canvas>
            </div>
            <div class="col-sm-6">
                <canvas id="differenzaGiorPrecGrafico" width="400" height="200"></canvas>
            </div>
            <div class="col-sm-6">
                <canvas id="casiPositiviAttualiGrafico" width="400" height="200"></canvas>
            </div>
            <div class="col-sm-6">
                <canvas id="casiDimessiGuaritiGrafico" width="400" height="200"></canvas>
            </div>
            <div class="col-sm-6">
                <canvas id="statoOspedaliGrafico" width="400" height="200"></canvas>
            </div>
            <div class="col-sm-6">
                <canvas id="divisioneCasiAttualiGrafico" width="400" height="200"></canvas>
            </div>
            <div class="col-sm-12">
                <canvas id="tamponiGrafico" width="400" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(() => {
        // Reversing arrays because data from DB are DESC ordered
        reverseDataArrays();
        drawGraphs();
    });

    function reverseDataArrays(){
        differenza_giorno_precedente.reverse();
        casi_positivi_attuali.reverse();
        casi_dimessi_guariti.reverse();
        casi_deceduti.reverse();
        casi_totali.reverse();

        casi_ospedalizzati.reverse();
        casi_isolamento_domestico.reverse();

        ospedali_ricoverati_sintomi.reverse();
        ospedali_terapia_intensiva.reverse();

        tamponi.reverse();

        labels.reverse();
    }

    function drawGraphs(){
        var casiTotaliGrafico = document.getElementById('casiTotaliGrafico');
        var myLineChart = new Chart(casiTotaliGrafico, {
            type: 'line',
            fill: false,
            data:{
                labels: labels,
                datasets: [{
                    label: 'Casi totali',
                    backgroundColor: chartColors.purple,
                    borderColor: chartColors.purple,
                    fill: false,
                    data: casi_totali,
                },{
                    label: 'Casi positivi attuali',
                    backgroundColor: chartColors.yellow,
                    borderColor: chartColors.yellow,
                    fill: false,
                    data: casi_positivi_attuali,
                }]
            }
        });

        var differenzaGiorPrecGrafico = document.getElementById('differenzaGiorPrecGrafico');
        var myLineChart = new Chart(differenzaGiorPrecGrafico, {
            type: 'line',
            fill: false,
            data:{
                labels: labels,
                datasets: [{
                    backgroundColor: chartColors.orange,
                    borderColor: chartColors.orange,
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

        var casiPositiviAttualiGrafico = document.getElementById('casiPositiviAttualiGrafico');
        var myLineChart = new Chart(casiPositiviAttualiGrafico, {
            type: 'line',
            fill: false,
            data:{
                labels: labels,
                datasets: [{
                    backgroundColor: chartColors.red,
                    borderColor: chartColors.red,
                    fill: false,
                    data: casi_deceduti,
                }]
            },
            options: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: 'Deceduti'
                },
            }
        });

        var casiDimessiGuaritiGrafico = document.getElementById('casiDimessiGuaritiGrafico');
        var myLineChart = new Chart(casiDimessiGuaritiGrafico, {
            type: 'line',
            fill: false,
            data:{
                labels: labels,
                datasets: [{
                    backgroundColor: chartColors.green,
                    borderColor: chartColors.green,
                    fill: false,
                    data: casi_dimessi_guariti,
                }]
            },
            options: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: 'Dimessi guariti'
                },
            }
        });

        var statoOspedaliGrafico = document.getElementById('statoOspedaliGrafico');
        var myLineChart = new Chart(statoOspedaliGrafico, {
            type: 'line',
            fill: false,
            data:{
                labels: labels,
                datasets: [{
                    label: 'Ricoverati',
                    backgroundColor: chartColors.yellow,
                    borderColor: chartColors.yellow,
                    fill: false,
                    data: ospedali_ricoverati_sintomi,
                },{
                    label: 'Terapia intensiva',
                    backgroundColor: chartColors.red,
                    borderColor: chartColors.red,
                    fill: false,
                    data: ospedali_terapia_intensiva,
                }]
            }
        });

        var divisioneCasiAttualiGrafico = document.getElementById('divisioneCasiAttualiGrafico');
        var myLineChart = new Chart(divisioneCasiAttualiGrafico, {
            type: 'line',
            fill: false,
            data:{
                labels: labels,
                datasets: [{
                    label: 'Casi ospedalizzati',
                    backgroundColor: chartColors.purple,
                    borderColor: chartColors.purple,
                    fill: false,
                    data: casi_ospedalizzati,
                },{
                    label: 'Casi isolamento domestico',
                    backgroundColor: chartColors.green,
                    borderColor: chartColors.green,
                    fill: false,
                    data: casi_isolamento_domestico,
                }]
            }
        });
        
        var tamponiGrafico = document.getElementById('tamponiGrafico');
        var myLineChart = new Chart(tamponiGrafico, {
            type: 'line',
            fill: false,
            data:{
                labels: labels,
                datasets: [{
                    backgroundColor: chartColors.grey,
                    borderColor: chartColors.grey,
                    fill: false,
                    data: tamponi,
                }]
            },
            options: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: 'Tamponi'
                },
            }
        });
    }
        
</script>

@endsection