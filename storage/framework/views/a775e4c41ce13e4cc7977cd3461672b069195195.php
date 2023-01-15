<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.projects'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>

    <?php $__env->slot('title'); ?> Task  <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<?php echo $__env->make('layouts.flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1 py-1">My Tasks</h4>














                </div><!-- end card header -->
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table
                            class="table table-borderless table-nowrap table-centered align-middle mb-0">
                            <thead class="table-light text-muted">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Dedline</th>
                                <th scope="col">Status</th>
                                <th scope="col">Assignee</th>
                            </tr>
                            </thead><!-- end thead -->
                            <tbody>
                            <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <label class="form-check-label ms-1">
                                                <?php echo e($item->name); ?>

                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-muted"><?php echo e($item->end_date); ?></td>

                                    <td>
                                        <span class="badge badge-soft-<?php echo e(config('constants.status_color')[$item->status]); ?>">
                                            <?php echo e(config('constants.task_status')[$item->status]); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <div class="avatar-group flex-nowrap">
                                            <?php $__currentLoopData = $item->assignUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="avatar-group-item">
                                                    <a href="javascript: void(0);" class="d-inline-block">
                                                        <?php echo \App\Helper\Helper::avatar($assignUser->avatar, $assignUser->name); ?>

                                                    </a>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </td>
                                </tr><!-- end -->
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->
                    </div>
                    <div class="align-items-center mt-xl-3 mt-4 justify-content-between d-flex">
                        <div class="flex-shrink-0">
                            <div class="text-muted">Showing <span class="fw-semibold"><?php echo e($tasks->count()); ?></span> of <span
                                    class="fw-semibold"> <?php echo e($tasks->total()); ?></span> Results
                            </div>
                        </div>

                        <?php echo e($tasks->links('vendor.pagination.custom')); ?>

                    </div>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <!-- apexcharts -->
    <script src="<?php echo e(URL::asset('/assets/libs/apexcharts/apexcharts.min.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('/assets/js/pages/dashboard-projects.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mchdmana/public_html/resources/views/task/mytasks.blade.php ENDPATH**/ ?>