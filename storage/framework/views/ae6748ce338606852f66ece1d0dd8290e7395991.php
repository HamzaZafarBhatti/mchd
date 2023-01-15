<?php $__env->startSection('title'); ?>
   Dashboard | <?php echo e($department->name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.main_breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Dashboard
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            <?php echo e($department->name); ?>

        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <?php echo $__env->make('layouts.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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
                                        Pending <?php echo e($object_name); ?></p>
                                    <div class="d-flex align-items-center mb-3">
                                        <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                                                                data-target="<?php echo e($monthly['pending']); ?>">0</span></h4>
                                        <span class="badge badge-soft-danger fs-12">
                                            <?php echo e(\App\Helper\Helper::getPercent($monthly['all'], $monthly['pending'])); ?>

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
                                    <p class="text-uppercase fw-medium text-muted mb-3">In Progress <?php echo e($object_name); ?></p>
                                    <div class="d-flex align-items-center mb-3">
                                        <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                                                                data-target="<?php echo e($monthly['inprogress']); ?>">0</span></h4>
                                        <span class="badge badge-soft-success fs-12">

                                            <?php echo e(\App\Helper\Helper::getPercent($monthly['all'], $monthly['inprogress'])); ?>

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
                                        Completed <?php echo e($object_name); ?></p>
                                    <div class="d-flex align-items-center mb-3">
                                        <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                                                                data-target="<?php echo e($monthly['completed']); ?>">0</span>
                                        </h4>
                                        <span class="badge badge-soft-danger fs-12">

                                            <?php echo e(\App\Helper\Helper::getPercent($monthly['all'], $monthly['completed'])); ?>

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
                            <h4 class="card-title mb-0 flex-grow-1"><?php echo e($object_name); ?> Status</h4>
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
                                    <h2 class="me-3 ff-secondary mb-0"><?php echo e($monthly['all']); ?></h2>
                                    <div>
                                        <p class="text-muted mb-0">Total <?php echo e($object_name); ?></p>
                                    </div>
                                </div>


                                <?php $__currentLoopData = $monthly; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($key !== "all"): ?>
                                    <div
                                        class="d-flex justify-content-between border-bottom border-bottom-dashed py-2">
                                        <p class="fw-medium mb-0"><i
                                                class="ri-checkbox-blank-circle-fill text-<?php echo e(\App\Helper\Helper::getStatusColor($key)); ?> align-middle me-2"></i>
                                            <?php echo e(config('constants.project_status')[$key]); ?></p>
                                        <div>
                                            <span class="text-muted pe-5"><?php echo e($val); ?> <?php echo e($object_name); ?></span>
                                            
                                        </div>
                                    </div><!-- end -->
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-xl-9 col-md-9">
                    <div class="card card-height-100">
                        <div class="card-header border-0 align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1"><?php echo e($object_name); ?> Overview (<?php echo e($yearly['all']); ?>)</h4>
                            <p class="text-muted text-truncate mb-0">In this year</p>
                        </div><!-- end card header -->

                        <div class="card-header p-0 border-0 bg-soft-light">
                            <div class="row g-0 text-center">
                                <?php $__currentLoopData = $yearly; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($key !== 'all'): ?>
                                    <div class="col-3 col-sm-2">
                                        <div class="p-3 border border-dashed border-start-0">
                                            <h5 class="mb-1">
                                                <span class="counter-value" data-target="<?php echo e($yearly[$key]); ?>">0</span>
                                            </h5>
                                            <p class="text-muted mb-0"><?php echo e(\App\Helper\Helper::getStatus(1, $key)); ?></p>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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


<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <!-- apexcharts -->
    <script src="<?php echo e(URL::asset('/assets/libs/apexcharts/apexcharts.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script-bottom'); ?>
    <script>
        var linechartcustomerColors = ['#3577f1', '#0ab39c', '#405189',
            '#212529', '#f7b84b', '#f06548'];;

        var options = {
            series: [
                {
                    name: 'Pending',
                    type: 'bar',
                    data: <?php echo json_encode($month12['pending'], 15, 512) ?>
                },
                {
                    name: 'In Progress',
                    type: 'bar',
                    data: <?php echo json_encode($month12['inprogress'], 15, 512) ?>
                },
                {
                    name: 'Completed',
                    type: 'bar',
                    data: <?php echo json_encode($month12['completed'], 15, 512) ?>
                },
                {
                    name: 'Not Yet Started',
                    type: 'bar',
                    data: <?php echo json_encode($month12['notyetstarted'], 15, 512) ?>
                },
                {
                    name: 'Overdue',
                    type: 'bar',
                    data: <?php echo json_encode($month12['overdue'], 15, 512) ?>
                },
                {
                    name: 'Cancelled',
                    type: 'bar',
                    data: <?php echo json_encode($month12['cancelled'], 15, 512) ?>
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
            series: [ <?php echo e($monthly['pending']); ?>, <?php echo e($monthly['inprogress']); ?>, <?php echo e($monthly['completed']); ?>

                , <?php echo e($monthly['notyetstarted']); ?>, <?php echo e($monthly['overdue']); ?>, <?php echo e($monthly['cancelled']); ?>],
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\mchd-manager\resources\views/dashboard.blade.php ENDPATH**/ ?>