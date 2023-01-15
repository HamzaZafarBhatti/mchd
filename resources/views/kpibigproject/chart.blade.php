@php
$pending_cnt = $big_project->projects->where('status', 'pending')->count();
$inprogress_cnt = $big_project->projects->where('status', 'inprogress')->count();
$completed_cnt = $big_project->projects->where('status', 'completed')->count();
$notyetstarted_cnt = $big_project->projects->where('status', 'notyetstarted')->count();
$overdue_cnt = $big_project->projects->where('status', 'overdue')->count();
$cancelled_cnt = $big_project->projects->where('status', 'cancelled')->count();
@endphp
@extends('layouts.master')
@section('title')
    @lang('translation.big_project_detail')
@endsection
@section('css')
    <link href="{{asset('assets/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css')}}" rel="stylesheet"/>
@endsection
@section('content')
    @include('layouts.errors')
    @include('layouts.flash-message')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mt-n4 mx-n4">
                <div class="bg-soft-primary">
                    <div class="card-body pb-0 px-4">
                        <div class="row mb-3">
                            <div class="col-md">
                                <div class="row align-items-center g-3">
                                    <div class="col-md-auto">
                                        {!! \App\Helper\Helper::avatar($big_project->boss->avatar, $big_project->boss->name, 'avatar-md', 30, auth() && auth()->user()->id === $big_project->boss->id) !!}
                                    </div>
                                    <div class="col-md">
                                        <div>
                                            <h4 class="fw-bold">{{$big_project->name}}</h4>
                                            <div class="hstack gap-3 flex-wrap">
                                                <div>Department : <span class="fw-medium">{{$big_project->department->name}}</span></div>
                                                <div class="vr"></div>
                                                <div>Manager : <span class="fw-medium">{{$big_project->boss->name}}</span></div>
                                                <div class="vr"></div>
                                                <div>Create Date : <span class="fw-medium">{{\App\Helper\Helper::letter_date($big_project->created_at)}}</span></div>
                                                <div class="vr"></div>
                                                <div>Start Date : <span class="fw-medium">{{\App\Helper\Helper::letter_date($big_project->start_date)}}</span></div>
                                                <div class="vr"></div>
                                                <div>Due Date : <span class="fw-medium">{{\App\Helper\Helper::letter_date($big_project->end_date)}}</span></div>
                                                <div class="vr"></div>
                                                @if(\App\Helper\Helper::isNew($big_project->created_at))
                                                    <div class="badge rounded-pill bg-info fs-12">New</div>
                                                @endif
                                                {{--                                                <div class="badge rounded-pill bg-danger fs-12">High</div>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>


    <div class="row">
        <div class="col-xxl-3">
            <div class="card card-height-100">
                <div class="card-header border-0 align-items-center d-flex">
                    <p class="text-uppercase fw-semibold fs-12 mb-1">All projects by completion status</p>
                </div><!-- end cardheader -->
                <div class="card-body">
                    <div id="portfolio_donut_charts" data-colors='["--vz-secondary", "--vz-success", "--vz-primary", "--vz-dark", "--vz-warning", "--vz-danger"]' class="apex-charts" dir="ltr"></div>

                    <ul class="list-group list-group-flush border-dashed mb-0 mt-3 pt-2">
                        <li class="list-group-item px-0">
                            <div class="d-flex">
                                <div class="flex-grow-1 ms-2">
                                    <p class="fs-12 mb-0 text-muted">
                                        <i class="mdi mdi-circle fs-10 align-middle text-secondary me-1"></i>
                                        Pending
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <p class="text-primary fs-12 mb-0">{{$pending_cnt}}</p>
                                </div>
                            </div>
                        </li><!-- end -->

                        <li class="list-group-item px-0">
                            <div class="d-flex">
                                <div class="flex-grow-1 ms-2">
                                    <p class="fs-12 mb-0 text-muted">
                                        <i class="mdi mdi-circle fs-10 align-middle text-success me-1"></i>
                                        InProgress
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <p class="text-primary fs-12 mb-0">{{$inprogress_cnt}}</p>
                                </div>
                            </div>
                        </li><!-- end -->

                        <li class="list-group-item px-0">
                            <div class="d-flex">
                                <div class="flex-grow-1 ms-2">
                                    <p class="fs-12 mb-0 text-muted">
                                        <i class="mdi mdi-circle fs-10 align-middle text-primary me-1"></i>
                                        Completed
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <p class="text-primary fs-12 mb-0">{{$completed_cnt}}</p>
                                </div>
                            </div>
                        </li><!-- end -->


                        <li class="list-group-item px-0">
                            <div class="d-flex">
                                <div class="flex-grow-1 ms-2">
                                    <p class="fs-12 mb-0 text-muted">
                                        <i class="mdi mdi-circle fs-10 align-middle text-dark me-1"></i>
                                        Not Yet Started
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <p class="text-primary fs-12 mb-0">{{$notyetstarted_cnt}}</p>
                                </div>
                            </div>
                        </li><!-- end -->

                        <li class="list-group-item px-0">
                            <div class="d-flex">
                                <div class="flex-grow-1 ms-2">
                                    <p class="fs-12 mb-0 text-muted">
                                        <i class="mdi mdi-circle fs-10 align-middle text-warning me-1"></i>
                                        Overdue
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <p class="text-primary fs-12 mb-0">{{$overdue_cnt}}</p>
                                </div>
                            </div>
                        </li><!-- end -->

                        <li class="list-group-item px-0">
                            <div class="d-flex">
                                <div class="flex-grow-1 ms-2">
                                    <p class="fs-12 mb-0 text-muted">
                                        <i class="mdi mdi-circle fs-10 align-middle text-danger me-1"></i>
                                        Cancelled
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <p class="text-primary fs-12 mb-0">{{$cancelled_cnt}}</p>
                                </div>
                            </div>
                        </li><!-- end -->

                    </ul><!-- end -->
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xxl-9 order-xxl-0 order-first">
            <div class="card card-height-100">
                <div class="card-header border-0 align-items-center d-flex">
                    <p class="text-uppercase fw-semibold fs-12 mb-1 flex-grow-1">Overview</p>
                    <div class="flex-shrink-0">
                        <form action="">
                            <input type="text" name="year" value="{{$year}}" class="form-control form-control-sm" id="datepicker">
                        </form>
                    </div>
                </div><!-- end card header -->

                <div class="card-body p-0 pb-2">
                    <div>
                        <div id="projects-overview-chart"
                             data-colors='["--vz-primary", "--vz-warning", "--vz-success", "--vz-success"]'
                             dir="ltr" class="apex-charts"></div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->

    <div class="row">
        <div class="d-flex justify-content-start">
            <a class="btn btn-danger" href="{{url("biglist")}}">Back</a>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
{{--    <script src="{{ URL::asset('/assets/js/pages/dashboard-crypto.init.js') }}"></script>--}}
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="{{asset('assets/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js')}}"></script>
@endsection


@section('script-bottom')
    <script>

        var donutchartportfolioColors =  ['#3577f1', '#0ab39c', '#405189',
            '#212529', '#f7b84b', '#f06548'];

        var options = {
            series: [{{$pending_cnt}}, {{$inprogress_cnt}}, {{$completed_cnt}},
                {{$notyetstarted_cnt}}, {{$overdue_cnt}}, {{$cancelled_cnt}}],
            labels: ["Pending", "InpProgress", "Completed", "Not Yet Started", "Overdue", "Cancelled"],
            chart: {
                type: "donut",
                height: 224
            },
            plotOptions: {
                pie: {
                    size: 100,
                    offsetX: 0,
                    offsetY: 0,
                    donut: {
                        // size: "70%",
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: "18px",
                                offsetY: -5
                            },
                            value: {
                                show: true,
                                fontSize: "20px",
                                color: "#343a40",
                                fontWeight: 500,
                                offsetY: 5,
                                formatter: function formatter(val) {
                                    return val;
                                }
                            },
                            total: {
                                show: true,
                                fontSize: "13px",
                                label: "Total",
                                color: "#9599ad",
                                fontWeight: 500,
                                formatter: function formatter(w) {
                                    return w.globals.seriesTotals.reduce(function (a, b) {
                                        return a + b;
                                    }, 0);
                                }
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: true,
                dropShadow: {
                    enabled: false
                }
            },
            legend: {
                show: false
            },
            yaxis: {
                labels: {
                    formatter: function formatter(value) {
                        return value;
                    }
                }
            },
            stroke: {
                lineCap: "round",
                width: 2
            },
            colors: donutchartportfolioColors
        };
        var chart = new ApexCharts(document.querySelector("#portfolio_donut_charts"), options);
        chart.render();



        var linechartcustomerColors =  ['#3577f1', '#0ab39c', '#405189',
            '#212529', '#f7b84b', '#f06548'];
        options = {
            series: [
                {
                    name: 'Pending',
                    type: 'bar',
                    data: @json($bar_chart['pending'])
                },
                {
                    name: 'In Progress',
                    type: 'bar',
                    data: @json($bar_chart['inprogress'])
                },
                {
                    name: 'Completed',
                    type: 'bar',
                    data: @json($bar_chart['completed'])
                },
                {
                    name: 'Not Yet Started',
                    type: 'bar',
                    data: @json($bar_chart['notyetstarted'])
                },
                {
                    name: 'Overdue',
                    type: 'bar',
                    data: @json($bar_chart['overdue'])
                },
                {
                    name: 'Cancelled',
                    type: 'bar',
                    data: @json($bar_chart['cancelled'])
                }
            ],
            chart: {
                height: 460,
                type: 'line',
                toolbar: {
                    show: false
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
                    right: -2,
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
                y: [{
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
                }]
            }
        };
        chart = new ApexCharts(document.querySelector("#projects-overview-chart"), options);
        chart.render();



        $("#datepicker").datepicker( {
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true,
            orientation: "bottom right"
        }).on('changeDate', function(e){
            $("form").submit();
        });

    </script>
@endsection
