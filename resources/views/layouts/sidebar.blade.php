<aside class="main-sidebar sidebar-dark-primary elevation-4">
    {{-- Brand Logo --}}
    <a href="/" class="brand-link text-center">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    {{-- Sidebar --}}
    <div class="sidebar">
        {{-- Sidebar Menu --}}
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                <li class="nav-header">{{__('sidebar.world')}}</li>
                <li class="nav-item">
                    <a href="{{ route('nations') }}" class="nav-link">
                        <i class="nav-icon fas fa-globe-europe"></i>
                        <p>
                            {{__('sidebar.nations')}}
                        </p>
                    </a>
                </li>
                <li class="nav-header">{{__('sidebar.italy')}}</li>
                <li class="nav-item">
                    <a href="{{ route('regions') }}" class="nav-link">
                        <i class="nav-icon fas fa-map-marked-alt"></i>
                        <p>
                            {{__('sidebar.regions')}}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('provinces') }}" class="nav-link">
                        <i class="nav-icon fas fa-city"></i>
                        <p>
                            {{__('sidebar.provinces')}}
                        </p>
                    </a>
                </li>
                <li class="nav-header">{{__('sidebar.data_source')}}</li>
                <li class="nav-item">
                    <a href="https://github.com/pcm-dpc/COVID-19" target="_blank" class="nav-link">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Protezione Civile Italiana
                        </p>
                    </a>
                    <a href="https://data.europa.eu/euodp/it/data/dataset/covid-19-coronavirus-data/resource/260bbbde-2316-40eb-aec3-7cd7bfc2f590" target="_blank" class="nav-link">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            OpenData UE
                        </p>
                    </a>
                </li>
                <li class="nav-header">{{__('sidebar.other')}}</li>
                <li class="nav-item">
                    <a href="https://github.com/ElCresh/Covid19-Statistics" target="_blank" class="nav-link">
                        <i class="nav-icon fab fa-github"></i>
                        <p>
                            Github
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        {{-- /.sidebar-menu --}}

        {{-- Page Sidebar Options --}}
        @yield('sidebar-options')

    </div>
    {{-- /.sidebar --}}
</aside>
