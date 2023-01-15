<div class="card card-height-100">
    <div class="card-header border-0 align-items-center">
        <div class="col-sm-3">
            <form action="">
                <input type="text" name="year" value="<?php echo e($year); ?>" class="form-control form-control-sm" id="datepicker">
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
                data: <?php echo json_encode($bar_chart['pending'], 15, 512) ?>
            },
            {
                name: 'In Progress',
                type: 'bar',
                data: <?php echo json_encode($bar_chart['inprogress'], 15, 512) ?>
            },
            {
                name: 'Completed',
                type: 'bar',
                data: <?php echo json_encode($bar_chart['completed'], 15, 512) ?>
            },
            {
                name: 'Not Yet Started',
                type: 'bar',
                data: <?php echo json_encode($bar_chart['notyetstarted'], 15, 512) ?>
            },
            {
                name: 'Overdue',
                type: 'bar',
                data: <?php echo json_encode($bar_chart['overdue'], 15, 512) ?>
            },
            {
                name: 'Cancelled',
                type: 'bar',
                data: <?php echo json_encode($bar_chart['cancelled'], 15, 512) ?>
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
            url: '<?php echo e(url('bigproject/chart')); ?>',
            method: 'post',
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                id: <?php echo e($big_project->id); ?>,
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
<?php /**PATH /home/mchdmana/public_html/resources/views/bigproject/item.blade.php ENDPATH**/ ?>