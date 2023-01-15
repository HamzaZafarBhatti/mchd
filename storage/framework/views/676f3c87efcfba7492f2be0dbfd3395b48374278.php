<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.projects'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css_bottom'); ?>
    <!--datatable css-->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <!--datatable responsive css-->
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="position-relative mx-n4 mt-n4">
        <?php echo $__env->make('layouts.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="profile-wid-bg profile-setting-img" style="height: 100px">
            
        </div>
    </div>

    <div class="row">
        <div class="col-xxl-3">
            <div class="card mt-n5">
                <div class="card-body p-4">
                    <div class="text-center">
                        <?php echo \App\Helper\Helper::avatar($user->avatar, $user->name, 'avatar-xl', 45); ?>

                        <h5 class="fs-16 mb-1"><?php echo e($user->name); ?></h5>
                        <p class="text-muted mb-0"><?php echo e($user->department->name); ?></p>
                        <?php if($user->role == 1): ?>
                            <p class="text-muted mb-0">
                                <span class="badge badge-soft-info">
                                    Manager
                                </span>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-xxl-9">
            <div class="card mt-xxl-n5">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                <i class="fas fa-home"></i>
                                Personal Details
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="firstnameInput" class="form-label">Full
                                            Name</label>
                                        <input type="text" class="form-control" disabled id="firstnameInput"
                                               placeholder="Enter your firstname" value="<?php echo e($user->name); ?>">
                                    </div>
                                </div>
                                <!--end col-->


                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="emailInput" class="form-label">Email
                                            Address</label>
                                        <input type="email" class="form-control" id="emailInput"
                                               placeholder="Enter your email" value="<?php echo e($user->email); ?>" disabled>
                                    </div>
                                </div>
                                <!--end col-->


                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="emailInput" class="form-label">Department</label>
                                        <input type="email" class="form-control"
                                               placeholder="" value="<?php echo e($user->department->name); ?>" disabled>
                                    </div>
                                </div>
                                <!--end col-->

                            <!--end col-->
                            </div>
                            <!--end row-->

                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="table-responsive table-card">
                                        <table class="table table-hover table-striped align-middle table-nowrap mb-0">
                                        <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Code</th>
                                            <th scope="col">Department</th>
                                            <th scope="col">ReadOnly</th>
                                            <th scope="col">Status Changeable</th>
                                            <th scope="col">Other Creatable</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <th scope="row"><?php echo e($department->code); ?></th>
                                            <td><?php echo e($department->name); ?></td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <?php if($department->code == $user->department_code || $user->role == 2): ?>
                                                        <input class="form-check-input" data-code="<?php echo e($department->code); ?>" type="checkbox" role="switch" checked disabled>
                                                    <?php else: ?>
                                                        <input class="form-check-input" data-code="<?php echo e($department->code); ?>" type="checkbox" onchange="onChanged(this, <?php echo e($department->code); ?>, 1)" role="switch" <?php echo e($user->details->where("department_code", $department->code)->where('type', 1)->count()? 'checked': ''); ?>>
                                                    <?php endif; ?>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="form-check form-switch">
                                                    <?php if(($user->role == 2) || // super admin
                                                        ($user->department_code == $department->code && $user->role == 1)): ?>
                                                        <input class="form-check-input" data-code="<?php echo e($department->code); ?>" type="checkbox" role="switch" checked disabled>
                                                    <?php else: ?>
                                                        <input class="form-check-input" data-code="<?php echo e($department->code); ?>" type="checkbox" onchange="onChanged(this, <?php echo e($department->code); ?>, 3)" role="switch" <?php echo e($user->details->where("department_code", $department->code)->where('type', 3)->count()? 'checked': ''); ?>>
                                                    <?php endif; ?>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="form-check form-switch">
                                                    <?php if(($user->role == 2) || // super admin
                                                        ($user->department_code == $department->code && $user->role == 1)): ?>
                                                        <input class="form-check-input" data-code="<?php echo e($department->code); ?>" type="checkbox" role="switch" checked disabled>
                                                    <?php else: ?>
                                                        <input class="form-check-input" data-code="<?php echo e($department->code); ?>" type="checkbox" onchange="onChanged(this, <?php echo e($department->code); ?>, 2)" role="switch" <?php echo e($user->details->where("department_code", $department->code)->where('type', 2)->count()? 'checked': ''); ?>>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                            <!--end row-->

                            <?php if($user->role > 0): ?>
                                <div class="row mt-5">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">
                                                    KPI Permission
                                                </h5><br>
                                                <div class="form-check form-switch">
                                                        <?php if($user->role == 2): ?>
                                                            <input class="form-check-input" data-code="0" type="checkbox" role="switch" checked disabled>
                                                        <?php else: ?>
                                                            <?php
                                                                $is_checked = 1;
                                                                foreach($kpis as $item) {
                                                                    if(!$user->assignedKpis->where("kpi_id", $item->id)->count()) {
                                                                        $is_checked = 0;
                                                                        break;
                                                                    }
                                                                }
                                                            ?>
                                                            <input id="item-all" class="form-check-input" data-code="0" type="checkbox" onchange="onChangedAssignedKpiAll(this)" role="switch" <?php echo e($is_checked? 'checked': ''); ?>>
                                                        <?php endif; ?>
                                                        Assign All
                                                    </div>
                                            </div>
                                            <div class="card-body">
                                                <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                                    <thead class="table-dark">
                                                    <tr>
                                                        <th scope="col">Group</th>
                                                        <th scope="col">Criteria</th>
                                                        <th scope="col">Assigned</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $__currentLoopData = $kpis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <th scope="row"><?php echo e($item->group->name); ?></th>
                                                            <td><?php echo e($item->criteria); ?></td>
                                                            <td>
                                                                <div class="form-check form-switch">
                                                                    <?php if($user->role == 2): ?>
                                                                        <input id="department<?php echo e($department->code); ?>" class="form-check-input" data-code="<?php echo e($department->code); ?>" type="checkbox" role="switch" checked disabled>
                                                                    <?php else: ?>
                                                                        <input id="item<?php echo e($item->id); ?>" class="form-check-input" data-code="<?php echo e($item->id); ?>" type="checkbox" onchange="onChangedAssignedKpi(this, <?php echo e($item->id); ?>)" role="switch" <?php echo e($user->assignedKpis->where("kpi_id", $item->id)->count()? 'checked': ''); ?>>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!--end row-->
                            <?php endif; ?>
                        </div>
                        <!--end tab-pane-->
                    </div>
                        <!--end tab-pane-->
                    <!--end row-->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xl-12 text-start">
            <a href="javascript:history.go(-1)" class="btn btn-danger">back</a>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script-bottom'); ?>
    <script>

        $(document).ready(function() {
            $('#example').DataTable();

        });


        $(document).ajaxSend(function() {
            $("#overlay").fadeIn(50);
        });
        let user_id = <?php echo e($user->id); ?>;
        let total_item_count = <?php echo e(count($kpis)); ?>;
        let active_item = <?php echo e($user->assignedKpis->count()); ?>;

        function onChanged(obj, code, type) {
            if ($(obj).is(":checked")){
                changeDetail(user_id, code, 1, type);
            }else {
                changeDetail(user_id, code, 0, type);
            }
        }

        function changeDetail(user_id, code, set = 0, type){
            $.ajax({
                method: 'post',
                url: '<?php echo e(url('admin/change_detail')); ?>',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    user_id: user_id,
                    code: code,
                    set: set,
                    type: type
                },
                success: function (response) {
                    if (response.code === 1)
                        notification_success("Changed Successfully");
                    else
                        notification("Unfortunately failed");
                },
                error: function (response){
                    notification("Unfortunately failed");
                }
            }).done(function () {
                setTimeout(function(){
                    $("#overlay").fadeOut(200);
                },500);
            });
        }


        function onChangedAssignedKpi(obj, kpi_id) {
            if ($(obj).is(":checked")){
                changeAssignedKpi(user_id, kpi_id, 1);
                if(++active_item == total_item_count) {
                    document.getElementById("item-all").checked = "checked";
                }
            } else {
                changeAssignedKpi(user_id, kpi_id, 0);
                active_item--;
                document.getElementById("item-all").checked = "";
            }
        }
        
        function onChangedAssignedKpiAll(obj) {
            <?php $__currentLoopData = $kpis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                if ($(obj).is(":checked")){
                    changeAssignedKpi(user_id, <?php echo e($item->id); ?>, 1);
                } else {
                    changeAssignedKpi(user_id, <?php echo e($item->id); ?>, 0);
                }
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        }

        function changeAssignedKpi(user_id, kpi_id, set = 0){
            $.ajax({
                method: 'post',
                url: '<?php echo e(url('admin/change_assign_kpi')); ?>',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    user_id: user_id,
                    kpi_id: kpi_id,
                    set: set,
                },
                success: function (response) {
                    if (response.code === 1) {
                        if(set == 1) {
                            document.getElementById("item" + kpi_id).checked = "checked";
                        } else {
                            document.getElementById("item" + kpi_id).checked = "";
                        }
                        notification_success("Changed Successfully");
                    } else {
                        notification("Unfortunately failed");
                    }
                },
                error: function (response){
                    notification("Unfortunately failed");
                }
            }).done(function () {
                setTimeout(function(){
                    $("#overlay").fadeOut(200);
                },500);
            });
        }

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mchdmana/public_html/resources/views/admin/user_detail.blade.php ENDPATH**/ ?>