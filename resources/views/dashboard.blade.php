@extends('layouts.master')
@section('title')
   Dashboard | {{$department->name}}
@endsection
@section('content')
    @component('components.main_breadcrumb')
        @slot('li_1')
            Dashboard
        @endslot
        @slot('title')
            {{$department->name}}
        @endslot
    @endcomponent
    @include('layouts.errors')
    @include('layouts.flash-message')

    <div class="row">
        <div class="col-xxl-12 col-md-12 col-lg-12">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span
                                        class="avatar-title bg-soft-primary text-primary rounded-2 fs-2">
                                        <i data-feather="briefcase" class="text-primary"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 overflow-hidden ms-3">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                        Pending {{$object_name}}</p>
                                    <div class="d-flex align-items-center mb-3">
                                        <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                                                                data-target="{{$monthly['pending']}}">0</span></h4>
                                        <span class="badge badge-soft-danger fs-12">
                                            {{\App\Helper\Helper::getPercent($monthly['all'], $monthly['pending'])}}
                                            %</span>
                                    </div>
                                    <p class="text-muted text-truncate mb-0">Pending projects this month</p>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div>
                </div><!-- end col -->


                <div class="col-xl-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span
                                        class="avatar-title bg-soft-warning text-warning rounded-2 fs-2">
                                        <i data-feather="award" class="text-warning"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-medium text-muted mb-3">In Progress {{$object_name}}</p>
                                    <div class="d-flex align-items-center mb-3">
                                        <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                                                                data-target="{{$monthly['inprogress']}}">0</span></h4>
                                        <span class="badge badge-soft-success fs-12">
{{--                                            <i class="ri-arrow-up-s-line fs-13 align-middle me-1"></i>--}}
                                            {{\App\Helper\Helper::getPercent($monthly['all'], $monthly['inprogress'])}}
                                            %</span>
                                    </div>
                                    <p class="text-muted mb-0">InProgress projects this month</p>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div>
                </div><!-- end col -->

                <div class="col-xl-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-info text-info rounded-2 fs-2">
                                        <i data-feather="star" class="text-info"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 overflow-hidden ms-3">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                        Completed {{$object_name}}</p>
                                    <div class="d-flex align-items-center mb-3">
                                        <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                                                                data-target="{{$monthly['completed']}}">0</span>
                                        </h4>
                                        <span class="badge badge-soft-danger fs-12">
{{--                                            <i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>--}}
                                            {{\App\Helper\Helper::getPercent($monthly['all'], $monthly['completed'])}}
                                            %</span>
                                    </div>
                                    <p class="text-muted text-truncate mb-0">Completed projects this month</p>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div>
                </div><!-- end col -->
            </div><!-- end row -->

            <div class="row">
                <div class="col-xl-3 col-md-3">
                    <div class="card card-height-100">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">{{$object_name}} Status</h4>
                            <div class="flex-shrink-0">
                                <div class="dropdown card-header-dropdown">
                                    <a class="dropdown-btn text-muted" href="#" data-bs-toggle="dropdown"
                                       aria-haspopup="false" aria-expanded="true">
                                        <span id="duration_text">In this month</span>
                                    </a>
                                </div>
                            </div>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div id="prjects-status"
                                 data-colors='["--vz-success", "--vz-primary", "--vz-warning", "--vz-danger"]'
                                 class="apex-charts" dir="ltr"></div>
                            <div class="mt-3">
                                <div class="d-flex justify-content-center align-items-center mb-4">
                                    <h2 class="me-3 ff-secondary mb-0">{{$monthly['all']}}</h2>
                                    <div>
                                        <p class="text-muted mb-0">Total {{$object_name}}</p>
                                    </div>
                                </div>


                                @foreach($monthly as $key => $val)
                                    @if($key !== "all")
                                    <div
                                        class="d-flex justify-content-between border-bottom border-bottom-dashed py-2">
                                        <p class="fw-medium mb-0"><i
                                                class="ri-checkbox-blank-circle-fill text-{{\App\Helper\Helper::getStatusColor($key)}} align-middle me-2"></i>
                                            {{config('constants.project_status')[$key]}}</p>
                                        <div>
                                            <span class="text-muted pe-5">{{$val}} {{$object_name}}</span>
                                            {{--<span class="text-success fw-medium fs-12">15870hrs</span>--}}
                                        </div>
                                    </div><!-- end -->
                                    @endif
                                @endforeach
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-xl-9 col-md-9">
                    <div class="card card-height-100">
                        <div class="card-header border-0 align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">{{$object_name}} Overview ({{$yearly['all']}})</h4>
                            <p class="text-muted text-truncate mb-0">In this year</p>
                        </div><!-- end card header -->

                        <div class="card-header p-0 border-0 bg-soft-light">
                            <div class="row g-0 text-center">
                                @foreach($yearly as $key => $val)
                                    @if($key !== 'all')
                                    <div class="col-3 col-sm-2">
                                        <div class="p-3 border border-dashed border-start-0">
                                            <h5 class="mb-1">
                                                <span class="counter-value" data-target="{{$yearly[$key]}}">0</span>
                                            </h5>
                                            <p class="text-muted mb-0">{{\App\Helper\Helper::getStatus(1, $key)}}</p>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div><!-- end card header -->
                        <div class="card-body p-0 pb-2">
                            <div>
                                <div class="card-body p-0 pb-2">
                                    <div>
                                        <div id="projects-overview-chart"
                                             data-colors='["--vz-primary", "--vz-warning", "--vz-success", "--vz-success"]'
                                             dir="ltr" class="apex-charts"></div>
                                    </div>
                                </div><!-- end card body -->
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end col -->
    </div><!-- end row -->


@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection

@section('script-bottom')
    <script>
        var linechartcustomerColors = ['#3577f1', '#0ab39c', '#405189',
            '#212529', '#f7b84b', '#f06548'];;

        var options = {
            series: [
                {
                    name: 'Pending',
                    type: 'bar',
                    data: @json($month12['pending'])
                },
                {
                    name: 'In Progress',
                    type: 'bar',
                    data: @json($month12['inprogress'])
                },
                {
                    name: 'Completed',
                    type: 'bar',
                    data: @json($month12['completed'])
                },
                {
                    name: 'Not Yet Started',
                    type: 'bar',
                    data: @json($month12['notyetstarted'])
                },
                {
                    name: 'Overdue',
                    type: 'bar',
                    data: @json($month12['overdue'])
                },
                {
                    name: 'Cancelled',
                    type: 'bar',
                    data: @json($month12['cancelled'])
                }
            ],
            chart: {
                height: 460,
                type: 'line',
                toolbar: {
                    show: true
                }
            },
            stroke: {
                curve: 'smooth',
                dashArray: [0, 0, 0, 0, 0, 0],
                width: [0, 0, 0, 0, 0, 0]
            },
            fill: {
                opacity: [1, 1, 1, 1, 1, 1]
            },
            markers: {
                size: [0, 0, 0, 0, 0, 0],
                strokeWidth: 2,
                hover: {
                    size: 4
                }
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                axisTicks: {
                    show: false
                },
                axisBorder: {
                    show: false
                }
            },
            grid: {
                show: true,
                xaxis: {
                    lines: {
                        show: true
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
                padding: {
                    top: 0,
                    right: 10,
                    bottom: 15,
                    left: 10
                }
            },
            legend: {
                show: true,
                horizontalAlign: 'center',
                offsetX: 0,
                offsetY: -5,
                markers: {
                    width: 9,
                    height: 9,
                    radius: 6
                },
                itemMargin: {
                    horizontal: 10,
                    vertical: 0
                }
            },
            plotOptions: {
                bar: {
                    columnWidth: '30%',
                    barHeight: '70%'
                }
            },
            colors: linechartcustomerColors,
            tooltip: {
                shared: true,
                y: [
                    {
                    formatter: function formatter(y) {
                        if (typeof y !== "undefined") {
                            return y.toFixed(0);
                        }

                        return y;
                    }
                },
                    {
                        formatter: function formatter(y) {
                            if (typeof y !== "undefined") {
                                return y.toFixed(0);
                            }
                            return y;
                        }
                    },
                    {
                        formatter: function formatter(y) {
                            if (typeof y !== "undefined") {
                                return y.toFixed(0);
                            }
                            return y;
                        }
                    },
                    {
                        formatter: function formatter(y) {
                            if (typeof y !== "undefined") {
                                return y.toFixed(0);
                            }
                            return y;
                        }
                    },
                    {
                        formatter: function formatter(y) {
                            if (typeof y !== "undefined") {
                                return y.toFixed(0);
                            }
                            return y;
                        }
                    },

                    {
                        formatter: function formatter(y) {
                            if (typeof y !== "undefined") {
                                return y.toFixed(0);
                            }

                            return y;
                        }
                    }
                ]
            }
        };
        var chart = new ApexCharts(document.querySelector("#projects-overview-chart"), options);
        chart.render();



        var donutchartProjectsStatusColors = ['#3577f1', '#0ab39c', '#405189',
            '#212529', '#f7b84b', '#f06548'];
        options = {
            series: [ {{$monthly['pending']}}, {{$monthly['inprogress']}}, {{$monthly['completed']}}
                , {{$monthly['notyetstarted']}}, {{$monthly['overdue']}}, {{$monthly['cancelled']}}],
            labels: ["Pending", "InpProgress", "Completed", "Not Yet Started", "Overdue", "Cancelled"],
            chart: {
                type: "pie",
                height: 230
            },
            dataLabels: {
                enabled: true
            },
            legend: {
                show: false
            },
            stroke: {
                lineCap: "round",
                width: 0
            },
            colors: donutchartProjectsStatusColors
        };
        chart = new ApexCharts(document.querySelector("#prjects-status"), options);
        chart.render();
    </script>
@endsection
