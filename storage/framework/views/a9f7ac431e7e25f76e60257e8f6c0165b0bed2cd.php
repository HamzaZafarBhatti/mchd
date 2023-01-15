<div class="row">
    <div class="col-xs-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-header mb-0 d-flex justify-content-between">
                <div class="col-md-2 mt-1">
                    <label>Year</label>
                    <input type="text" name="year" value="<?php echo e($year); ?>" class="form-control" id="datepicker">
                </div>
                <div class="col-md-2 mt-1">
                    <label>Group</label>
                    <select class="form-select" name="type" id="group_id">
                        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option <?php echo e($item->id == $group->id? 'selected' : ''); ?> value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-2 mt-1">
                    <label>KPI</label>
                    <select class="form-select" name="type" id="kpi_id">
                        <?php $__currentLoopData = $group->kpis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                        <option <?php echo e($item->id == $kpi_id? 'selected' : ''); ?> value="<?php echo e($item->id); ?>"><?php echo e($item->criteria); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-2 mt-1">
                    <label>Ago</label>
                    <select class="form-select" name="year_cnt" id="year_cnt">
                        <?php for($i = 1; $i < 6; $i++): ?>
                            <option <?php echo e($i == $year_cnt? 'selected' : ''); ?> value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                        <?php endfor; ?>
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
                            <td><?php echo e($year); ?></td>
                            <td>Target</td>
                            <?php $__currentLoopData = $target; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td><?php echo e($item); ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>

                        <tr class="bg-soft-info">
                            <td><?php echo e($year); ?></td>
                            <td>Actual</td>
                            <?php $__currentLoopData = $actual; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td><?php echo e($item); ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>

                        <?php $__currentLoopData = $previous_year_dara_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $months): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($start = $start - 1); ?></td>
                                <td>Actual</td>
                                <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td><?php echo e($item); ?></td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <tr class="bg-soft-primary">
                            <td>Average</td>
                            <td>Actual</td>
                            <?php $__currentLoopData = $average; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td><?php echo e($item); ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                        <?php for($i = 1; $i <= 12; $i++): ?>
                            <option <?php echo e($i == $month? 'selected' : ''); ?> value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                        <?php endfor; ?>
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
                data: <?php echo json_encode($previous_year_actual, 15, 512) ?>
            }, {
                name: 'Target',
                data: <?php echo json_encode($target, 15, 512) ?>
            }, {
                name: 'Actual',
                data: <?php echo json_encode($actual, 15, 512) ?>
            }],
            colors: chartColumnColors,
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            },
            yaxis: {
                title: {
                    text: ' <?php echo e($unit); ?>'
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
                        return val + " <?php echo e($unit); ?>"
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
                url: "<?php echo e(url('kpi/update_kpi_chart')); ?>",
                method: 'post',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
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
            data: <?php echo json_encode($average, 15, 512) ?>
        }, {
            name: 'Target',
            type: 'column',
            data: <?php echo json_encode($target, 15, 512) ?>
        }, {
            name: 'Actual',
            type: 'column',
            data: <?php echo json_encode($actual, 15, 512) ?>
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
                text: '<?php echo e($unit); ?>',
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
                        return y.toFixed(2) + " <?php echo e($unit); ?>";
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
        series: <?php echo json_encode($sum_years, 15, 512) ?>,
        chart: {
            height: 300,
            type: 'pie',
        },
        labels: <?php echo json_encode($years, 15, 512) ?>,
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
<?php /**PATH /home/mchdmana/public_html/resources/views/admin/kpi/partial_chart.blade.php ENDPATH**/ ?>