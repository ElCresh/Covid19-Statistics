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
                <li class="nav-item">
                    <a href="{{ route('regions') }}" class="nav-link">
                        <i class="nav-icon fas fa-map"></i>
                        <p>
                            Regioni
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('provinces') }}" class="nav-link">
                        <i class="nav-icon fas fa-city"></i>
                        <p>
                            Province
                        </p>
                    </a>
                </li>
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
