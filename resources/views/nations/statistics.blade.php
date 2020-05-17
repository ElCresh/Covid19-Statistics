
@extends('layouts.app')

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
        <div class="title">
            @if ($stato->province_state != '')
                {{ $stato->province_state }} ({{ $stato->country_region }})
            @else
                {{ $stato->country_region }}
            @endif
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card text-white bg-dark mb-3 float-right">
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
            <b>*</b> "{{ __('statistics.active_case') }}" e "Variazione del totale positivi" calcolati automaticamente in base ai dati forniti
        </small>
    </div>
</div>

<ul class="nav nav-tabs mb-2" id="tabs-menu" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="data-tab" data-toggle="tab" href="#data" role="tab" aria-controls="home" aria-selected="true">Dati</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="graphs-tab" data-toggle="tab" href="#graphs" role="tab" aria-controls="profile" aria-selected="false">Grafici</a>
    </li>
</ul>
<div class="tab-content mb-2" id="tabs-content">
    <div class="tab-pane fade show active" id="data" role="tabpanel" aria-labelledby="data-tab">
        <div class="row">
            <div class="col table-responsive">
                <table class="table text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">{{ __('statistics.date') }}</th>
                            <th scope="col">{{ __('statistics.total_case') }}</th>
                            <th scope="col">{{ __('statistics.active_case') }}*</th>
                            <th scope="col">Variazione del totale positivi*</th>
                            <th scope="col">{{ __('statistics.recovered') }}</th>
                            <th scope="col">{{ __('statistics.total_deaths') }}</th>
                        </tr>
                    </thead>
                    <tbody>
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
                            <tr>
                                <th scope="row">{{ $date }}</th>
                                <td>{{ $data->confirmed }}</td>
                                <td>{{ $active_case }}</td>
                                <td>
                                    @if ($variation_active_case < 0)
                                        <span class="badge badge-success">{{ $variation_active_case }}</span>
                                    @elseif ($variation_active_case > 0)
                                        <span class="badge badge-danger">{{ $variation_active_case }}</span>
                                    @else
                                        <span class="badge badge-secondary">{{ $variation_active_case }}</span>
                                    @endif
                                </td>
                                <td>{{ $data->recovered }}</td>
                                <td>{{ $data->deaths }}</td>
                            </tr>
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
                <canvas id="variazioneCasiAttivi" width="400" height="200"></canvas>
            </div>
            <div class="col-sm-6">
                <canvas id="casiDimessi" width="400" height="200"></canvas>
            </div>
            <div class="col-sm-6">
                <canvas id="casiPositiviAttualiGrafico" width="400" height="200"></canvas>
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
        casi_attivi.reverse();
        casi_deceduti.reverse();
        casi_dimessi.reverse();
        casi_totali.reverse();

        variazione_casi_attivi.reverse();

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
                    label: '{{ __('statistics.total_case') }}',
                    backgroundColor: chartColors.purple,
                    borderColor: chartColors.purple,
                    fill: false,
                    data: casi_totali,
                },{
                    label: '{{ __('statistics.active_case') }}*',
                    backgroundColor: chartColors.yellow,
                    borderColor: chartColors.yellow,
                    fill: false,
                    data: casi_attivi,
                }]
            }
        });

        var variazioneCasiAttivi = document.getElementById('variazioneCasiAttivi');
        var myLineChart = new Chart(variazioneCasiAttivi, {
            type: 'line',
            fill: false,
            data:{
                labels: labels,
                datasets: [{
                    backgroundColor: chartColors.orange,
                    borderColor: chartColors.orange,
                    fill: false,
                    data: variazione_casi_attivi,
                }]
            },
            options: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: 'Variazione del totale positivi*'
                },
            }
        });

        var casiDimessi = document.getElementById('casiDimessi');
        var myLineChart = new Chart(casiDimessi, {
            type: 'line',
            fill: false,
            data:{
                labels: labels,
                datasets: [{
                    backgroundColor: chartColors.orange,
                    borderColor: chartColors.orange,
                    fill: false,
                    data: casi_dimessi,
                }]
            },
            options: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: '{{ __('statistics.recovered') }}'
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
                    text: '{{ __('statistics.total_deaths') }}'
                },
            }
        });
    }
</script>

@endsection