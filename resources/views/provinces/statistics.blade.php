
@extends('layouts.dashboard')

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
        <div class="h3">
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
    <div class="col-md-4 table-responsive">
        {{ $table }}
        @php
            $prec_giorno = 0;
        @endphp
        @foreach($datas as $index => $data)
            @php
                $date = new Carbon($data->data);

                if($index < ($datas->count() - 1)){
                    $prec_giorno = $datas[$index + 1]->totale_casi;
                }else{
                    $prec_giorno = 0;
                }

                $diff = $data->totale_casi - $prec_giorno;

                // diff lookahead for progression
                if($index < ($datas->count() - 2)){
                    $prec_giorno_ahead = $datas[$index + 2]->totale_casi;
                }else{
                    $prec_giorno_ahead = 0;
                }

                $diff_lookahead = $prec_giorno - $prec_giorno_ahead;
                //--
            @endphp
            <script>
                // Saving data for charts
                differenza_giorno_precedente.push({{ $diff }});
                casi_totali.push({{ $data->totale_casi }});
                labels.push('{{ $date->toDateString() }}');
            </script>
        @endforeach
    </div>
    <div class="col-md-8">
        <div id="grph_1"></div>
        <div id="grph_2"></div>
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
        casi_totali.reverse();
        labels.reverse();
    }

    function drawGraphs(){
        var grph_1 = document.getElementById('grph_1');
        Plotly.newPlot( grph_1, [
            {
                x: labels,
                y: casi_totali,
                mode: 'lines',
                name: 'Casi totali',
                line: {
                    color: 'red'
                }
            }
        ], 
        {
            plotly_config,
        } );

        var grph_2 = document.getElementById('grph_2');
        Plotly.newPlot( grph_2, [
            {
                x: labels,
                y: differenza_giorno_precedente,
                mode: 'lines',
                name: 'Variazione nuovi positivi',
                line: {
                    color: 'orange'
                }
            }
        ], 
        {
            plotly_config
        } );
    }
</script>

@endsection