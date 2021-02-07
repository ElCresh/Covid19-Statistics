
@extends('layouts.dashboard')

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
        <div class="h3">
            {{ $region->denominazione_regione }}
        </div>
    </div>
    <div class="col">
        <div class="card text-white bg-dark mb-3 float-right">
            <div class="card-body">
                <h5 class="card-title">Dettagli:</h5>
                <p class="card-text text-left links">
                    <b>Denominazione:</b> {{ $region->denominazione_regione }} <br />
                    <b>Coordinate:</b> <a target="_blank" href="https://maps.google.it/?q={{ $region->lat }},{{ $region->long }}">{{ $region->lat }},{{ $region->long }}</a> <br />
                </p>
            </div>
        </div>
    </div>
</div>


<div class="card card-nav-tabs card-plain">
    <div class="card-header card-header-info">
        <div class="nav-tabs-navigation">
            <div class="nav-tabs-wrapper">
                <ul class="nav nav-tabs" data-tabs="tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#data" data-toggle="tab">Dati</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#graphs" data-toggle="tab">Grafici</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card-body ">
        <div class="tab-content text-center">
            <div class="tab-pane active" id="data">
                {{ $table }}

                @foreach($datas as $index => $data)
                    @php
                        $date = new Carbon($data->data);
                    @endphp
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
            </div>

            <div class="tab-pane active" id="graphs">
                <div id="grph_1_1"></div>
                <div id="grph_1_2"></div>
                <div id="grph_2_1"></div>
                <div id="grph_2_2"></div>
                <div id="grph_3_1"></div>
                <div id="grph_3_2"></div>
            </div>
        </div>
    </div>
</div>

<script>
    var plotly_config = {
        responsive: true,
    }

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

        casi_testati.reverse();
        tamponi.reverse();

        labels.reverse();
    }

    function drawGraphs(){
        var grph_1_1 = document.getElementById('grph_1_1');
        Plotly.newPlot( grph_1_1, [
            {
                x: labels,
                y: casi_totali,
                mode: 'lines',
                name: 'Casi totali',
                line: {
                    color: 'red'
                }
            },
            {
                x: labels,
                y: casi_positivi_attuali,
                mode: 'lines',
                name: 'Casi positivi attuali',
            }
        ], 
        {
            plotly_config,
        } );

        var grph_1_2 = document.getElementById('grph_1_2');
        Plotly.newPlot( grph_1_2, [
            {
                x: labels,
                y: differenza_giorno_precedente,
                mode: 'lines',
                name: 'Variazione nuovi positivi',
                line: {
                    color: 'orange'
                }
            },
            {
                x: labels,
                y: variazione_totale_positivi,
                mode: 'lines',
                name: 'Variazione del totale positivi',
                line: {
                    color: 'blu'
                }
            }
        ], 
        {
            plotly_config
        } );

        var grph_2_1 = document.getElementById('grph_2_1');
        Plotly.newPlot( grph_2_1, [
            {
                x: labels,
                y: casi_ospedalizzati,
                mode: 'lines',
                name: 'Casi ospedalizzati',
                line: {
                    color: 'purple'
                }
            },
            {
                x: labels,
                y: casi_isolamento_domestico,
                mode: 'lines',
                name: 'Casi isolamento domestico',
                line: {
                    color: 'green'
                }
            }
        ], 
        {
            plotly_config
        } );

        var grph_2_2 = document.getElementById('grph_2_2');
        Plotly.newPlot( grph_2_2, [
            {
                x: labels,
                y: casi_dimessi_guariti,
                mode: 'lines',
                name: 'Dimessi guariti',
                line: {
                    color: 'green'
                }
            },
            {
                x: labels,
                y: casi_deceduti,
                mode: 'lines',
                name: 'Deceduti',
                line: {
                    color: 'red'
                }
            }
        ], 
        {
            plotly_config
        } );
        var grph_3_1 = document.getElementById('grph_3_1');
        Plotly.newPlot( grph_3_1, [
            {
                x: labels,
                y: ospedali_terapia_intensiva,
                type: 'bar',
                name: 'Terapia intensiva',
                marker: {
                    color: 'orange'
                }
            },
            {
                x: labels,
                y: ospedali_ricoverati_sintomi,
                type: 'bar',
                name: 'Ricoverati con sintomi',
                marker: {
                    color: 'yellow'
                }
            }
        ], 
        {
            plotly_config,
            barmode: 'stack'
        },);

        var grph_3_2 = document.getElementById('grph_3_2');
        Plotly.newPlot( grph_3_2, [
            {
                x: labels,
                y: casi_testati,
                mode: 'lines',
                name: 'Casi testati',
                line: {
                    color: 'green'
                }
            },
            {
                x: labels,
                y: tamponi,
                mode: 'lines',
                name: 'Tamponi',
                line: {
                    color: 'grey'
                }
            }
        ], 
        {
            plotly_config
        } );

        $('#graphs').removeClass('active');
    }
</script>

@endsection