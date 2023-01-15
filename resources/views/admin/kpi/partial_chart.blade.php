<div class="row">
    <div class="col-xs-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-header mb-0 d-flex justify-content-between">
                <div class="col-md-2 mt-1">
                    <label>Year</label>
                    <input type="text" name="year" value="{{$year}}" class="form-control" id="datepicker">
                </div>
                <div class="col-md-2 mt-1">
                    <label>Group</label>
                    <select class="form-select" name="type" id="group_id">
                        @foreach($groups as $item)
                            <option {{$item->id == $group->id? 'selected' : ''}} value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 mt-1">
                    <label>KPI</label>
                    <select class="form-select" name="type" id="kpi_id">
                        @foreach($group->kpis as $item)                        <option {{$item->id == $kpi_id? 'selected' : ''}} value="{{$item->id}}">{{$item->criteria}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 mt-1">
                    <label>Ago</label>
                    <select class="form-select" name="year_cnt" id="year_cnt">
                        @for($i = 1; $i < 6; $i++)
                            <option {{$i == $year_cnt? 'selected' : ''}} value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>

            </div>
            <div class="card-body">
                <div class="table-card table-responsive">
                    <table class="table table-nowrap">
                        <thead>
                        <tr>
                            <th>Year</th>
                            <th>Type</th>
                            <th>Jan</th>
                            <th>Feb</th>
                            <th>Mar</th>
                            <th>Apr</th>
                            <th>May</th>
                            <th>Jun</th>
                            <th>Jul</th>
                            <th>Aug</th>
                            <th>Sep</th>
                            <th>Oct</th>
                            <th>Nov</th>
                            <th>Dec</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $start = $year;
                        ?>
                        <tr class="bg-soft-info">
                            <td>{{$year}}</td>
                            <td>Target</td>
                            @foreach($target as $item)
                                <td>{{$item}}</td>
                            @endforeach
                        </tr>

                        <tr class="bg-soft-info">
                            <td>{{$year}}</td>
                            <td>Actual</td>
                            @foreach($actual as $item)
                                <td>{{$item}}</td>
                            @endforeach
                        </tr>

                        @foreach($previous_year_dara_arr as $months)
                            <tr>
                                <td>{{$start = $start - 1}}</td>
                                <td>Actual</td>
                                @foreach($months as $item)
                                    <td>{{$item}}</td>
                                @endforeach
                            </tr>
                        @endforeach

                        <tr class="bg-soft-primary">
                            <td>Average</td>
                            <td>Actual</td>
                            @foreach($average as $item)
                                <td>{{$item}}</td>
                            @endforeach
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-8 col-xl-8">
        <div class="card card-height-100">
            <div class="card-header">
                <h4 class="card-title mb-0">Compare with average</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="line_area_charts" class="apex-charts" dir="ltr"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>


    <div class="col-xs-12 col-md-4 col-xl-4">
        <div class="card card-height-100">
            <div class="card-header d-flex align-items-center">
                <h4 class="card-title mb-0 flex-grow-1">Compare by year</h4>
                <div class="flex-shrink-0">
                    <label>Till Month </label>
                    <select class="form-select" name="month" id="month" style="">
                        @for($i = 1; $i <= 12; $i++)
                            <option {{$i == $month? 'selected' : ''}} value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="monochrome_pie_chart" class="apex-charts" dir="ltr"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
</div>


<div class="row">
    <div class="col-xs-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Compare with previous year</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="column_chart"  class="apex-charts" dir="ltr"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
</div>



<script>

    // Basic Column Chart
    var chartColumnColors = ['#3577f1', '#f7b84b', '#0ab39c'];
    if (chartColumnColors) {
        var options = {
            chart: {
                height: 350,
                type: 'bar',
                toolbar: {
                    show: true,
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '45%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            series: [{
                name: 'Actual of Previous Year',
                data: @json($previous_year_actual)
            }, {
                name: 'Target',
                data: @json($target)
            }, {
                name: 'Actual',
                data: @json($actual)
            }],
            colors: chartColumnColors,
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            },
            yaxis: {
                title: {
                    text: ' {{$unit}}'
                }
            },
            grid: {
                borderColor: '#f1f1f1',
            },
            fill: {
                opacity: 1

            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " {{$unit}}"
                    }
                }
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#column_chart"),
            options
        );

        chart.render();
    }

    $(document).ajaxSend(function() {
        $("#overlay").fadeIn(50);
    });


    function getKpiCharts(kpi_id, year, group_id, year_cnt, month = null) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "{{url('kpi/update_kpi_chart')}}",
                method: 'post',
                data: {
                    _token: '{{csrf_token()}}',
                    group_id: group_id,
                    year: year,
                    kpi_id: kpi_id,
                    year_cnt: year_cnt,
                    month: month
                },
            }).done(function (data){
                resolve(data);
                setTimeout(function(){
                    $("#overlay").fadeOut(200);
                },500);
            }).fail((err) => reject(err));
        });
    }

    $("#datepicker").datepicker( {
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        autoclose: true,
        orientation: "bottom right"
    }).on('changeDate', function(e){
        update_view($("#kpi_id").val(), $("#datepicker").val(), $("#group_id").val(), $("#year_cnt").val());
    });

    $("#group_id").change(function () {
        update_view(null, $("#datepicker").val(), $("#group_id").val(), $("#year_cnt").val());
    });

    $("#kpi_id").change(function () {
        update_view($("#kpi_id").val(), $("#datepicker").val(), $("#group_id").val(), $("#year_cnt").val());
    });

    $("#year_cnt").change(function () {
        update_view($("#kpi_id").val(), $("#datepicker").val(), $("#group_id").val(), $("#year_cnt").val());
    });

    $("#month").change(function () {
        update_view($("#kpi_id").val(), $("#datepicker").val(), $("#group_id").val(), $("#year_cnt").val(), $("#month").val());
    });

    function update_view(kpi_id, year, group_id, year_cnt, month = null){
        getKpiCharts(kpi_id, year, group_id, year_cnt, month)
            .then((result) => {
                $('#kpi_chart_container').empty();
                $('#kpi_chart_container').html(result);
            })
            .catch((err) => {
                console.log(err);
            })
    }




    var chartLineAreaMultiColors = chartColumnColors = ['#3577f1', '#f7b84b', '#0ab39c'];
    options = {
        series: [{
            name: 'Average',
            type: 'line',
            data: @json($average)
        }, {
            name: 'Target',
            type: 'column',
            data: @json($target)
        }, {
            name: 'Actual',
            type: 'column',
            data: @json($actual)
        }],
        chart: {
            height: 350,
            type: 'line',
            stacked: false,
            toolbar: {
                show: true,
            }
        },
        stroke: {
            width: [2, 2, 2],
            curve: 'smooth'
        },
        plotOptions: {
            bar: {
                columnWidth: '50%'
            }
        },

        fill: {
            opacity: [0.85, 0.25, 1],
            gradient: {
                inverseColors: false,
                shade: 'light',
                type: "vertical",
                opacityFrom: 0.85,
                opacityTo: 0.55,
                stops: [0, 100, 100, 100]
            }
        },
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        markers: {
            size: 0
        },
        xaxis: {
            //type: 'datetime'
        },
        yaxis: {
            title: {
                text: '{{$unit}}',
            },
            labels: {
                show: true,
                formatter: function(val) {
                    return (val).toFixed(2);
                },
            },
            min: 0,
        },
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function (y) {
                    if (typeof y !== "undefined") {
                        return y.toFixed(2) + " {{$unit}}";
                    }
                    return y;

                }
            }
        },
        colors: chartLineAreaMultiColors
    };

    chart = new ApexCharts(document.querySelector("#line_area_charts"), options);
    chart.render();



    // monochrome_pie_chart
    options = {
        series: @json($sum_years),
        chart: {
            height: 300,
            type: 'pie',
        },
        labels: @json($years),
        theme: {
            monochrome: {
                enabled: true,
                color: '#405189',
                shadeTo: 'light',
                shadeIntensity: 0.6
            }
        },

        plotOptions: {
            pie: {
                dataLabels: {
                    offset: -5
                }
            }
        },
        title: {
            text: "",
            style: {
                fontWeight: 500,
            },
        },
        dataLabels: {
            formatter: function (val, opts) {
                var name = opts.w.globals.labels[opts.seriesIndex];
                return [name, val.toFixed(1) + '%'];
            },
            dropShadow: {
                enabled: false,
            }
        },
        legend: {
            show: false
        }
    };

    chart = new ApexCharts(document.querySelector("#monochrome_pie_chart"), options);
    chart.render();
</script>
