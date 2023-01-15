<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ url('/') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/logo-sm.png') }}" alt="" height="38">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('assets/images/logo-dark.png') }}" alt="" height="33">
            </span>
        </a>

        <!-- Light Logo-->
        <a href="{{ url('/') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/logo-sm.png') }}" alt="" height="38">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('assets/images/logo-light.png') }}" alt="" height="33">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title">
                    <span>@lang('translation.project_management')</span>
                </li>
                <li class="nav-item">
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#dashboard" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-3-line"></i> <span>@lang('translation.dashboards')</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Request::is(['dashboard/1', 'dashboard/2', 'dashboard/3', 'dashboard/4', 'dashboard/5', '/']) ? 'show' : '' }}"
                        id="dashboard">
                        <ul class="nav nav-sm flex-column">
                            @foreach ($departments as $item)
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('dashboard/' . $item->id) ? 'active' : '' }}"
                                        href="{{ url('dashboard/' . $item->id) }}">
                                        {{ $item->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>

                @auth
                    @php($current_user = auth()->user())
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ url('/kpi/charts') }}">
                            <i class="ri-flow-chart"></i> <span>KPI Charts</span>
                        </a>
                    </li>

                    @if (\App\Helper\Helper::kpiDataAddable($current_user))
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/kpi/add_kpi_data') }}">
                                <i class="ri-keyboard-fill"></i> <span>KPI Data</span>
                            </a>
                        </li>
                    @endif

                    @if ($current_user->role != 2)
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ Request::is([
                                'tasks/' . $current_user->department_code,
                                'biglist/' . $current_user->department_code,
                                'bigcreate/' . $current_user->department_code,
                            ])
                                ? 'active'
                                : '' }}"
                                href="{{ url('/tasks/' . $current_user->department_code) }}">
                                <i class="{{ $current_user->department->icon }}"></i>
                                <span>{{ $current_user->department->name }}</span>
                            </a>
                        </li>

                        @foreach ($current_user->details()->groupBy('department_code')->get() as $item)
                            @if ($item->department->code != $current_user->department_code)
                                <li class="nav-item">
                                    <a class="nav-link menu-link {{ Request::is('tasks/' . $item->department->code) ? 'active' : '' }}"
                                        href="{{ url('/tasks/' . $item->department->code) }}">
                                        <i class="{{ $item->department->icon }}"></i>
                                        <span>{{ $item->department->name }}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @else
                        @foreach ($departments as $item)
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ Request::is('tasks/' . $item->code) ? 'active' : '' }}"
                                    href="{{ url('/tasks/' . $item->code) }}">
                                    <i class="{{ $item->icon }}"></i> <span>{{ $item->name }}</span>
                                </a>
                            </li>
                        @endforeach
                        <li class="menu-title"><span>@lang('translation.admin_panel')</span></li>
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ Request::is('admin/chart') ? 'active' : '' }}"
                                href="{{ url('admin/chart') }}">
                                <i class="ri-pie-chart-2-line"></i> <span>@lang('translation.charts')</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ Request::is('admin/usermanagement') ? 'active' : '' }}"
                                href="{{ url('admin/usermanagement') }}">
                                <i class="ri-user-3-fill"></i> <span>@lang('translation.usermanagement')</span>
                            </a>
                        </li>

                        <li class="menu-title">
                            <span>@lang('translation.kpi')</span>
                        </li>
                        <li class="nav-item">
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/kpi/setting') }}">
                                <i class="ri-lock-password-fill"></i> <span>KPI Components</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/kpi/add') }}">
                                <i class="ri-key-2-fill"></i> <span>KPIs</span>
                            </a>
                        </li>

                        {{--                            <li class="nav-item"> --}}
                        {{--                                <a class="nav-link menu-link" href="{{url('/kpi/add_kpi_data')}}"> --}}
                        {{--                                    <i class="ri-keyboard-fill"></i> <span>KPI Data</span> --}}
                        {{--                                </a> --}}
                        {{--                            </li> --}}
                    @endif

                    @if ($current_user->role == 1)
                        <li class="menu-title">
                            <span>@lang('translation.kpi')</span>
                        </li>
                        <li class="nav-item">
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/kpi/setting') }}">
                                <i class="ri-lock-password-fill"></i> <span>KPI Components</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/kpi/add') }}">
                                <i class="ri-key-2-fill"></i> <span>KPIs</span>
                            </a>
                        </li>
                    @endif

                @endauth
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>

<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
