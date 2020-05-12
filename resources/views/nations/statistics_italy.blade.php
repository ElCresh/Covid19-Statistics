
@extends('layouts.app')

{{---------------Content---------------}}
@section('content')

@php
    use Carbon\Carbon;
@endphp

<script>
    var differenza_giorno_precedente = [];
    var variazione_totale_positivi = [];
    var casi_positivi_attuali = [];
    var casi_dimessi_guariti = [];
    var casi_deceduti = [];
    var casi_totali = [];

    var casi_ospedalizzati = [];
    var casi_isolamento_domestico = [];

    var ospedali_ricoverati_sintomi = [];
    var ospedali_terapia_intensiva = [];

    var casi_testati = [];
    var tamponi = [];

    var labels = [];

</script>

<div class="row">
    <div class="col">
        <div class="title">
            Italia
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
                            <th scope="col">Totale ricoverati con sintomi</th>
                            <th scope="col">Totale terapia intensiva</th>
                            <th scope="col">Totale ospedalizzati</th>
                            <th scope="col">Totale isolamento domicilare</th>
                            <th scope="col">Attualmente positivi</th>
                            <th scope="col">Variazione del totale positivi</th>
                            <th scope="col">Totale dimessi</th>
                            <th scope="col">Totale deceduti</th>
                            <th scope="col">Totale casi</th>
                            <th scope="col">Casi testati</th>
                            <th scope="col">Totale tamponi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datas as $index =>$data)
                            @php
                                $date = new Carbon($data->data);
                            @endphp
                            <tr>
                                <th scope="row">{{ $date->toDateString() }}</th>
                                <td>{{ $data->ricoverati_con_sintomi }}</td>
                                <td>{{ $data->terapia_intensiva }}</td>
                                <td>{{ $data->totale_ospedalizzati }}</td>
                                <td>{{ $data->isolamento_domiciliare }}</td>
                                <td>{{ $data->totale_attualmente_positivi }}</td>
                                <td>
                                    @if ($data->variazione_totale_positivi < 0)
                                        <span class="badge badge-success">{{ $data->variazione_totale_positivi }}</span>
                                    @elseif ($data->variazione_totale_positivi > 0)
                                        <span class="badge badge-danger">{{ $data->variazione_totale_positivi }}</span>
                                    @else
                                        <span class="badge badge-secondary">{{ $data->variazione_totale_positivi }}</span>
                                    @endif
                                </td>
                                <td>{{ $data->dimessi_guariti }}</td>
                                <td>{{ $data->deceduti }}</td>
                                <td>{{ $data->totale_casi }}</td>
                                <td>
                                    @if($data->casi_testati >= 0)
                                        {{ $data->casi_testati }}
                                    @else
                                        <span class="badge badge-warning">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $data->tamponi }}</td>
                            </tr>
                            <script>
                                // Saving data for charts
                                differenza_giorno_precedente.push({{ $data->nuovi_attualmente_positivi }});
                                variazione_totale_positivi.push({{ $data->variazione_totale_positivi }});
                                casi_positivi_attuali.push({{ $data->totale_attualmente_positivi }});
                                casi_dimessi_guariti.push({{ $data->dimessi_guariti }});
                                casi_deceduti.push({{ $data->deceduti }});
                                casi_totali.push({{ $data->totale_casi }});
        
                                casi_ospedalizzati.push({{ $data->totale_ospedalizzati }});
                                casi_isolamento_domestico.push({{ $data->isolamento_domiciliare }});
        
                                ospedali_ricoverati_sintomi.push({{ $data->ricoverati_con_sintomi }});
                                ospedali_terapia_intensiva.push({{ $data->terapia_intensiva }});
        
                                tamponi.push({{ $data->tamponi }});
        
                                labels.push('{{ $date->toDateString() }}');
                            </script>
                            
                            @if($data->casi_testati >= 0)
                                <script>
                                    casi_testati.push({{ $data->casi_testati }});
                                </script>
                            @else
                                <script>
                                    casi_testati.push(null);
                                </script>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="graphs" role="tabpanel" aria-labelledby="graphs-tab">
        <div class="row">
            <div class="col-sm-6">
                <canvas id="grph_1_1" width="400" height="200"></canvas>
            </div>
            <div class="col-sm-6">
                <canvas id="grph_1_2" width="400" height="200"></canvas>
            </div>
            <div class="col-sm-6">
                <canvas id="grph_2_1" width="400" height="200"></canvas>
            </div>
            <div class="col-sm-6">
                <canvas id="grph_2_2" width="400" height="200"></canvas>
            </div>
            <div class="col-sm-6">
                <canvas id="grph_3_1" width="400" height="200"></canvas>
            </div>
            <div class="col-sm-6">
                <canvas id="grph_3_2" width="400" height="200"></canvas>
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
        variazione_totale_positivi.reverse();
        casi_positivi_attuali.reverse();
        casi_dimessi_guariti.reverse();
        casi_deceduti.reverse();
        casi_totali.reverse();

        casi_ospedalizzati.reverse();
        casi_isolamento_domestico.reverse();

        ospedali_ricoverati_sintomi.reverse();
        ospedali_terapia_intensiva.reverse();

        casi_testati.reverse();
        tamponi.reverse();

        labels.reverse();
    }

    function drawGraphs(){
        var grph_1_1 = document.getElementById('grph_1_1');
        var myLineChart = new Chart(grph_1_1, {
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

        var grph_1_2 = document.getElementById('grph_1_2');
        var myLineChart = new Chart(grph_1_2, {
            type: 'line',
            fill: false,
            data:{
                labels: labels,
                datasets: [{
                    label: 'Variazione nuovi positivi',
                    backgroundColor: chartColors.orange,
                    borderColor: chartColors.orange,
                    fill: false,
                    data: differenza_giorno_precedente,
                },{
                    label: 'Variazione del totale positivi',
                    backgroundColor: chartColors.green,
                    borderColor: chartColors.green,
                    fill: false,
                    data: variazione_totale_positivi,
                }]
            }
        });

        var grph_2_1 = document.getElementById('grph_2_1');
        var myLineChart = new Chart(grph_2_1, {
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

        var grph_2_2 = document.getElementById('grph_2_2');
        var myLineChart = new Chart(grph_2_2, {
            type: 'line',
            fill: false,
            data:{
                labels: labels,
                datasets: [{
                    label: 'Dimessi guariti',
                    backgroundColor: chartColors.green,
                    borderColor: chartColors.green,
                    fill: false,
                    data: casi_dimessi_guariti,
                },{
                    label: 'Deceduti',
                    backgroundColor: chartColors.red,
                    borderColor: chartColors.red,
                    fill: false,
                    data: casi_deceduti,
                }]
            }
        });

        var grph_3_1 = document.getElementById('grph_3_1');
        var myLineChart = new Chart(grph_3_1, {
            type: 'line',
            fill: false,
            data:{
                labels: labels,
                datasets: [{
                    label: 'Ricoverati con sintomi',
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

        var grph_3_2 = document.getElementById('grph_3_2');
        var myLineChart = new Chart(grph_3_2, {
            type: 'line',
            fill: false,
            data:{
                labels: labels,
                datasets: [{
                    label: 'Casi testati',
                    backgroundColor: chartColors.green,
                    borderColor: chartColors.green,
                    fill: false,
                    data: casi_testati,
                },{
                    label: 'Tamponi',
                    backgroundColor: chartColors.grey,
                    borderColor: chartColors.grey,
                    fill: false,
                    data: tamponi,
                }]
            }
        });
    }
        
</script>

@endsection