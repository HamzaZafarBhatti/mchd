@extends('layouts.master')
@section('title') @lang('translation.projects') @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('title') Dashboards  @endslot
    @endcomponent
    @include('layouts.flash-message')

    <div class="row">
        <div class="col-xl-4">
            <div class="card card-height-100">
                <div class="card-header">
                    <h4 class="card-title mb-0">Members</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div id="simple_pie_chart"
                         data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]'
                         class="apex-charts" dir="ltr"></div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        <!-- end col -->

        <div class="col-xl-8">
            <div class="card card-height-100">
                <div class="card-header">
                    <h4 class="card-title mb-0">Total, approved and unapproved members</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div id="line_chart_datalabel" data-colors='["--vz-primary", "--vz-success"]' class="apex-charts" dir="ltr"></div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>

    <div class="row">
        <div class="col-xxl-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="live-privie">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0">
                                <thead>
                                <tr>
                                    <th scope="col">Department</th>
                                    <th scope="col">Number of Members</th>
                                    <th scope="col">Big Projects</th>
                                    <th scope="col">Projects</th>
                                    <th scope="col">Tasks</th>
                                    <th scope="col">Sub Tasks</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($departments as $item)
                                    @if($item->id === 1)
                                        <tr>
                                            <th scope="row">{{$item->name}}</th>
                                            <td>{{$item->users->count()}}</td>
                                            <td>{{$item->bigprojects->count()}}</td>
                                            <td>{{$item->projects->count()}}</td>
                                            <td>{{$item->tasks->count()}}</td>
                                            <td>{{$item->subtasks->count()}}</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <th scope="row">{{$item->name}}</th>
                                            <td>{{$item->users->count()}}</td>
                                            <td></td>
                                            <td></td>
                                            <td>{{$item->tasks->count()}}</td>
                                            <td>{{$item->subtasks->count()}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/prismjs/prismjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection

@section('script-bottom')
    <script>
        var chartPieBasicColors = ['#3577f1', '#0ab39c', '#405189', '#f7b84b', '#f06548'];
        var options = {
            series: [{{$departments[0]->users->count()}}, {{$departments[1]->users->count()}}, {{$departments[2]->users->count()}},
                {{$departments[3]->users->count()}}, {{$departments[4]->users->count()}}],
            chart: {
                height: 300,
                type: 'pie'
            },
            labels: ['Clinical Improvement', 'Pediatrics', 'NICU', 'OBS/GYN', 'Pediatric Surgery'],
            legend: {
                position: 'bottom'
            },
            dataLabels: {
                dropShadow: {
                    enabled: false
                }
            },
            colors: chartPieBasicColors
        };
        var chart = new ApexCharts(document.querySelector("#simple_pie_chart"), options);
        chart.render();




        var linechartDatalabelColors = ['#3577f1', '#405189', '#f06548'];
        options = {
            chart: {
                height: 380,
                type: 'line',
                zoom: {
                    enabled: false
                },
                toolbar: {
                    show: false
                }
            },
            colors: linechartDatalabelColors,
            dataLabels: {
                enabled: false,
            },
            stroke: {
                width: [3, 3],
                curve: 'straight'
            },
            series: [{
                name: "Total",
                data: @json($data['total'])
            },
                {
                    name: "Approved",
                    data: @json($data['approved'])
                },
                {
                    name: "Unapproved",
                    data: @json($data['unapproved'])
                }
            ],
            title: {
                text: 'Number of each department',
                align: 'left',
                style: {
                    fontWeight: 500,
                },
            },
            grid: {
                row: {
                    colors: ['transparent', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.2
                },
                borderColor: '#f1f1f1'
            },
            markers: {
                style: 'inverted',
                size: 6
            },
            xaxis: {
                categories: @json($data['departments']),
                title: {
                    text: 'Departments'
                }
            },
            yaxis: {
                title: {
                    text: 'Number of Members'
                },
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                floating: true,
                offsetY: -25,
                offsetX: -5
            },
            responsive: [{
                breakpoint: 600,
                options: {
                    chart: {
                        toolbar: {
                            show: false
                        }
                    },
                    legend: {
                        show: false
                    },
                }
            }],
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

                ]
        }};

        chart = new ApexCharts(
            document.querySelector("#line_chart_datalabel"),
            options
        );
        chart.render();


    </script>
@endsection
