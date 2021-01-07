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
                            <th scope="col">Ingressi terapia intensiva</th>
                            <th scope="col">Variazione del totale positivi</th>
                            <th scope="col">Totale dimessi</th>
                            <th scope="col">Casi da sospetto diagnostico</th>
                            <th scope="col">Casi da screening</th>
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
                                <td>{{ $data->ingressi_terapia_intensiava }}</td>
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
                                <td>{{ $data->casi_da_sospetto_diagnostico }}</td>
                                <td>{{ $data->casi_da_screening }}</td>
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
        <div class="d-flex justify-content-center">
            <div id="grph_1_1" style="width: auto"></div>
        </div>
        <div class="d-flex justify-content-center">
            <div id="grph_1_2" style="width: auto"></div>
        </div>
        <div class="d-flex justify-content-center">
            <div id="grph_2_1" style="width: auto"></div>
        </div>
        <div class="d-flex justify-content-center">
            <div id="grph_2_2" style="width: auto"></div>
        </div>
        <div class="d-flex justify-content-center">
            <div id="grph_3_1" style="width: auto"></div>
        </div>
        <div class="d-flex justify-content-center">
            <div id="grph_3_2" style="width: auto"></div>
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
    }
        
</script>

@endsection