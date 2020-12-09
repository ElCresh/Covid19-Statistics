<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="covid19,statistics,statistiche,notiosoft,protezione,civile,je,sse,italia,san marino">
    <meta name="description" content="Dashboard di aggregazione dati su COVID-19 provanienti dal tutto il mondo">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    
    <script src="{{ asset('js/script.js') }}"></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    
    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div id="app" class="wrapper">
        {{-- Navbar --}}
        <nav class="main-header navbar navbar-expand navbar-dark bg-dark">
            {{-- Left navbar links --}}
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            {{-- Right navbar links --}}
            <ul class="navbar-nav ml-auto">
                {{--
                <li class="nav-item d-none d-sm-block">
                    <a href="https://bit.ly/SistemiCovidBax" target="_blank" class="nav-link">{{ __('sidebar.anti_covid_solutions') }}</a>
                </li>
                --}}
                <li class="nav-item">
                    <a href="{{ route('contact') }}" class="nav-link">{{ __('sidebar.more_on_project') }}</a>
                </li>
            </ul>
        </nav>

        @include('layouts.sidebar')

        <div class="content-wrapper">
        {{--<!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard v1</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->--}}

        {{-- Main content --}}
            <section class="content">
                <div class="container-fluid pt-3">
                    <div class="row">
                        <div class="col">
                            @yield('content')
                        </div>
                    </div>
                </div>
                {{-- /.container-fluid --}}
            </section>
            {{-- /.content --}}
        </div>
        {{-- /.content-wrapper --}}

        <footer class="main-footer">
            @include('layouts.footer')
        </footer>

        {{-- TODO is this needed?--}}
        {{--<!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->--}}
    </div>
    {{-- ./wrapper --}}

    {{-- TODO is this needed?--}}
    {{--<!-- Fix for bootstrap modals -->
    <script>
        $(document).on('click', '.open-modal', function(e){
            e.preventDefault();
            var modal_id = $(this).attr('data-target');
            $(modal_id).modal("toggle");
        });
    </script>--}}
@stack('scripts')
</body>
</html>