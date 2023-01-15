<div class="card card-height-100">
    <div class="card-header border-0 align-items-center">
        <div class="col-sm-3">
            <form action="">
                <input type="text" name="year" value="{{$year}}" class="form-control form-control-sm" id="datepicker">
            </form>
        </div>
    </div><!-- end card header -->

    <div class="card-body p-0 pb-2">
        <div>
            <div id="projects-overview-chart" dir="ltr" class="apex-charts"></div>
        </div>
    </div><!-- end card body -->
</div><!-- end card -->

<script>
    $(document).ajaxSend(function() {
        $("#overlay").fadeIn(50);
    });

    var linechartcustomerColors =  ['#3577f1', '#0ab39c', '#405189',
        '#212529', '#f7b84b', '#f06548'];
    var options = {
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
    var chart = new ApexCharts(document.querySelector("#projects-overview-chart"), options);
    chart.render();


    $("#datepicker").datepicker( {
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        autoclose: true,
        orientation: "bottom right"
    }).on('changeDate', function(e){
        $.ajax({
            url: '{{url('bigproject/chart')}}',
            method: 'post',
            data: {
                _token: '{{csrf_token()}}',
                id: {{$big_project->id}},
                year: $(this).val(),
            },
            success: function (response) {
                $('#chart').empty();
                $('#chart').html(response);
            },
            error: function (response) {

            },
            failure: function (response) {

            }
        }).done(function () {
            setTimeout(function(){
                $("#overlay").fadeOut(200);
            },500);
        });
    });

</script>
