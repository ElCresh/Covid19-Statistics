
@extends('layouts.app')

{{---------------Content---------------}}
@section('content')

@php
    use Carbon\Carbon;
@endphp

<script>
    var differenza_giorno_precedente = [];
    var casi_deceduti = [];
    var casi_totali = [];

    var labels = [];
</script>

<div class="row">
    <div class="col">
        <div class="title">
            {{ $stato->country_region }} {{ ($stato->province_state != '') ? '('.$stato->province_state.')' : '' }}
        </div>
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
                            <th scope="col">Data</th>
                            <th scope="col">Casi</th>
                            <th scope="col">Diff. prec. gior.</th>
                            <th scope="col">Deceduti</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datas as $index => $data)
                            @php
                                $date = new Carbon($data->last_update);

                                if($index < ($datas->count() - 1)){
                                    $prec_giorno = $datas[$index + 1]->confirmed;
                                }else{
                                    // Making starting difference to 0 becuase
                                    // csv format are inconsistent and not all
                                    // history is loaded on db
                                    $prec_giorno = $data->confirmed;
                                }
        
                                $diff = $data->confirmed - $prec_giorno;
                            @endphp
                            <tr>
                                <th scope="row">{{ $date }}</th>
                                <td>{{ $data->confirmed }}</td>
                                <td>{{ $diff }}</td>
                                <td>{{ $data->deaths }}</td>
                            </tr>
                            <script>
                                differenza_giorno_precedente.push({{ $diff }});
                                casi_deceduti.push({{ $data->deaths }});
                                casi_totali.push({{ $data->confirmed }});

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
    // Reversing arrays because data from DB are DESC ordered
    differenza_giorno_precedente.reverse();
    casi_deceduti.reverse();
    casi_totali.reverse();

    labels.reverse();
    //--

    $(document).ready(() => {
        var casiTotaliGrafico = document.getElementById('casiTotaliGrafico');
        var myLineChart = new Chart(casiTotaliGrafico, {
            type: 'line',
            fill: false,
            data:{
                labels: labels,
                datasets: [{
                    backgroundColor: chartColors.purple,
                    borderColor: chartColors.purple,
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
                    text: 'Casi positivi'
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
    });
</script>

@endsection