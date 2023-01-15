<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.projects'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.main_breadcrumb'); ?>
        <?php $__env->slot('title'); ?> <?php echo app('translator')->get('translation.charts'); ?>  <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_1'); ?> Admin panel <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
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
                                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($item->id === 1): ?>
                                        <tr>
                                            <th scope="row"><?php echo e($item->name); ?></th>
                                            <td><?php echo e($item->users->count()); ?></td>
                                            <td><?php echo e($item->bigprojects->count()); ?></td>
                                            <td><?php echo e($item->projects->count()); ?></td>
                                            <td><?php echo e($item->tasks->count()); ?></td>
                                            <td><?php echo e($item->subtasks->count()); ?></td>
                                        </tr>
                                    <?php else: ?>
                                        <tr>
                                            <th scope="row"><?php echo e($item->name); ?></th>
                                            <td><?php echo e($item->users->count()); ?></td>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo e($item->tasks->count()); ?></td>
                                            <td><?php echo e($item->subtasks->count()); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <!-- apexcharts -->
    <script src="<?php echo e(URL::asset('/assets/libs/apexcharts/apexcharts.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/libs/prismjs/prismjs.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script-bottom'); ?>
    <script>
        var chartPieBasicColors = ['#3577f1', '#0ab39c', '#405189', '#f7b84b', '#f06548'];
        var options = {
            series: [<?php echo e($departments[0]->users->count()); ?>, <?php echo e($departments[1]->users->count()); ?>, <?php echo e($departments[2]->users->count()); ?>,
                <?php echo e($departments[3]->users->count()); ?>, <?php echo e($departments[4]->users->count()); ?>],
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
                data: <?php echo json_encode($data['total'], 15, 512) ?>
            },
                {
                    name: "Approved",
                    data: <?php echo json_encode($data['approved'], 15, 512) ?>
                },
                {
                    name: "Unapproved",
                    data: <?php echo json_encode($data['unapproved'], 15, 512) ?>
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
                categories: <?php echo json_encode($data['departments'], 15, 512) ?>,
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mchdmana/public_html/resources/views/admin/chart.blade.php ENDPATH**/ ?>