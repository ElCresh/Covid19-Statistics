@extends('layouts.dashboard')

{{---------------Content---------------}}
@section('content')

@php
    use Carbon\Carbon;
@endphp

<script>
    var casi_attivi = [];
    var casi_deceduti = [];
    var casi_dimessi = [];
    var casi_totali = [];

    var variazione_casi_attivi = [];

    var labels = [];
</script>

<div class="row">
    <div class="col-sm-6">
        <div class="h2 mt-3">
            @if ($stato->province_state != '')
                {{ $stato->province_state }} ({{ $stato->country_region }})
            @else
                {{ $stato->country_region }}
            @endif
        </div>
    </div>
    <div class="col-sm-6">
        <div class="float-right">
            <div class="card text-white bg-dark mb-3">
                <div class="card-body">
                    <h5 class="card-title">Dettagli:</h5>
                    <p class="card-text text-left links">
                        @if ($stato->province_state != '')
                            <b>Denominazione Provincia/Stato:</b> {{ $stato->province_state }} <br />
                        @endif
                        <b>Denominazione Nazione:</b> {{ $stato->country_region }} <br />
                        <b>Coordinate:</b> <a target="_blank" href="https://maps.google.it/?q={{ $stato->latitude }},{{ $stato->longitude }}">{{ $stato->latitude }},{{ $stato->longitude }}</a> <br />
                    </p>
                </div>
            </div>
            <small class="float-right">
                <b>*</b> dati calcolati automaticamente in base ai dati forniti
            </small>
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
                <div class="row">
                    <div class="col table-responsive">
                        {{ $table }}
                        @foreach($datas as $index => $data)
                            @php
                                $date = new Carbon($data->last_update);

                                if($index < ($datas->count() - 1)){
                                    $active_case_prev = ($datas[$index + 1]->confirmed - ($datas[$index + 1]->recovered + $datas[$index + 1]->deaths));
                                }else{
                                    $active_case_prev = 0;
                                }

                                $active_case = ($data->confirmed - ($data->recovered + $data->deaths));
                                $variation_active_case = $active_case - $active_case_prev;
                            @endphp
                            <script>
                                // Saving data for charts
                                casi_attivi.push({{ $active_case }});
                                casi_deceduti.push({{ $data->deaths }});
                                casi_dimessi.push({{ $data->recovered }});
                                casi_totali.push({{ $data->confirmed }});

                                variazione_casi_attivi.push({{ $variation_active_case }});

                                labels.push('{{ $date }}');
                            </script>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="tab-pane active" id="graphs">
                <div id="graph_1"></div>
                <div id="graph_2"></div>
                <div id="graph_3"></div>
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
        casi_attivi.reverse();
        casi_deceduti.reverse();
        casi_dimessi.reverse();
        casi_totali.reverse();

        variazione_casi_attivi.reverse();

        labels.reverse();
    }

    function drawGraphs(){
        var graph_1 = document.getElementById('graph_1');
        Plotly.newPlot( graph_1, [
            {
                x: labels,
                y: casi_totali,
                mode: 'lines',
                name: '{{ __('statistics.total_case') }}',
                line: {
                    color: 'red'
                }
            },
            {
                x: labels,
                y: casi_attivi,
                mode: 'lines',
                name: '{{ __('statistics.active_case') }}*',
            }
        ], 
        {
            plotly_config,
        } );

        var graph_2 = document.getElementById('graph_2');
        Plotly.newPlot( graph_2, [
            {
                x: labels,
                y: variazione_casi_attivi,
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

        var graph_3 = document.getElementById('graph_3');
        Plotly.newPlot( graph_3, [
            {
                x: labels,
                y: casi_dimessi,
                mode: 'lines',
                name: '{{ __('statistics.recovered') }}',
                line: {
                    color: 'green'
                }
            },
            {
                x: labels,
                y: casi_deceduti,
                mode: 'lines',
                name: '{{ __('statistics.total_deaths') }}',
                line: {
                    color: 'red'
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