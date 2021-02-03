@php
    $route_name = Route::currentRouteName();
@endphp

<!doctype html>
<html lang="en">
    <head>
        <title>{{ config('app.name') }}</title>

        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <link rel="icon" href="/favicon.ico"/>

        <!--     Fonts and icons     -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

        <!-- CSS -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!--   Core JS Files   -->
        <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>     
        <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    </head>
    <body>
        <div class="wrapper">
            <div class="sidebar" data-color="white" data-background-color="darkblue" data-image="">
                <div class="logo"><a href="/" class="simple-text logo-normal">
                    {{ config('app.name') }}
                </a></div>
                <div class="sidebar-wrapper">
                    <ul class="nav">
                        <li class="nav-item {{ ($route_name == 'home' ? 'active' : '') }}">
                            <a class="nav-link" href="/">
                                <i class="material-icons">dashboard</i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-item {{ ($route_name == 'nations' ? 'active' : '') }}">
                            <a class="nav-link" href="{{ route('nations') }}">
                                <i class="material-icons">public</i>
                                <p>{{__('sidebar.nations')}}</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link disabled" disabled href="">
                                <p>{{__('sidebar.italy')}}</p>
                            </a>
                        </li>

                        <li class="nav-item {{ ($route_name == 'nation.statistics' ? 'active' : '') }}">
                            <a class="nav-link" href="{{ route('nation.statistics', ['sigla' => 'Italy']) }}">
                                <i class="material-icons">public</i>
                                <p>{{__('sidebar.global')}}</p>
                            </a>
                        </li>

                        <li class="nav-item {{ ($route_name == 'regions' ? 'active' : '') }}">
                            <a class="nav-link" href="{{ route('regions') }}">
                                <i class="material-icons">map</i>
                                <p>{{__('sidebar.regions')}}</p>
                            </a>
                        </li>
                        
                        <li class="nav-item {{ ($route_name == 'provinces' ? 'active' : '') }}">
                            <a class="nav-link" href="{{ route('provinces') }}">
                                <i class="material-icons">location_city</i>
                                <p>{{__('sidebar.provinces')}}</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link disabled" disabled href="">
                                <p>{{__('sidebar.data_source')}}</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="https://github.com/pcm-dpc/COVID-19" target="_blank">
                                <i class="material-icons">source</i>
                                <p>Protezione Civile Italiana</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="https://github.com/CSSEGISandData/COVID-19" target="_blank">
                                <i class="material-icons">source</i>
                                <p>Johns Hopkins CSSE</p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link disabled" disabled href="">
                                <p>{{__('sidebar.other')}}</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="https://github.com/ElCresh/Covid19-Statistics" target="_blank">
                                <i class="material-icons">code</i>
                                <p>Github</p>
                            </a>
                        </li>
                        
                        <li class="nav-item active-pro ">
                            <a class="nav-link" href="http://andreacrescentini.com" target="_blank">
                                <i class="material-icons">alternate_email</i>
                                <p>Andrea Crescentini</p>
                            </a>
                        </li>
                    </ul>
            </div>
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar sticky-top navbar-expand-lg bg-secondary">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <a class="navbar-brand" href="javascript:;">{{ config('app.name')}}</a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end">
                        {{-- Noting here --}}
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
            <div class="container-fluid pl-5 pr-5 pt-3">
                @yield('content')
            </div>
        </div>

        <script>
            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();
            $('.main-panel').perfectScrollbar('destroy');
            $('.main-panel').perfectScrollbar('update');
        </script>
    </body>
</html>