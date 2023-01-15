<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.projects'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.main_breadcrumb'); ?>
            <?php $__env->slot('li_1'); ?> Admin Panel <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?> User Management  <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <?php echo $__env->make('layouts.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1 py-1">Users</h4>
                    <div class="flex-shrink-0">
                        <div class="dropdown card-header-dropdown">
                            <form method="get" id="form_code">
                                <label>
                                    <select name="code" class="form-select form-select-sm" id="sel_department">
                                        <option <?php echo e($code == -1 ? 'selected' : ''); ?> value="">All</option>
                                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option <?php echo e($code == $item->code ? 'selected' : ''); ?> value="<?php echo e($item->code); ?>"><?php echo e($item->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </label>
                            </form>
                        </div>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-nowrap table-centered align-middle mb-0">
                            <thead class="table-light text-muted">
                            <tr>
                                <th scope="col">Avatar</th>
                                <th scope="col"><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('department.name', 'Department'));?>
                                    <?php if($sort=='department.name'): ?>
                                        <?php if($direction=='asc'): ?>
                                            <i class="las la-sort-alpha-up"></i>
                                        <?php else: ?>
                                            <i class="las la-sort-alpha-down"></i>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </th>

                                <th scope="col"><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('name', 'Name'));?>
                                    <?php if($sort=='name'): ?>
                                        <?php if($direction=='asc'): ?>
                                            <i class="las la-sort-alpha-up"></i>
                                        <?php else: ?>
                                            <i class="las la-sort-alpha-down"></i>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </th>
                                <th scope="col">Email</th>
                                <th scope="col">ReadOnly</th>
                                <th scope="col">Status Changeable</th>
                                <th scope="col">Other Creatable</th>
                                <th scope="col"><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('role', 'Permission'));?>
                                    <?php if($sort=='role'): ?>
                                        <?php if($direction=='asc'): ?>
                                            <i class="las la-sort-alpha-up"></i>
                                        <?php else: ?>
                                            <i class="las la-sort-alpha-down"></i>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                                <th scope="col">Remove</th>
                            </tr>
                            </thead><!-- end thead -->
                            <tbody>

                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <div class="avatar-group-item">
                                                <a href="<?php echo e(url('admin/users/'.$user->id)); ?>" class="d-inline-block">
                                                    <?php echo \App\Helper\Helper::avatar($user->avatar, $user->name); ?>

                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-muted">
                                       <span class="<?php echo e($user->role == 1? 'badge badge-soft-primary' : ''); ?>">
                                           <?php echo e($user->department->name); ?>

                                       </span>
                                    </td>
                                    <td class="text-muted">
                                        <span class="<?php echo e($user->role == 1? 'badge badge-soft-primary' : ''); ?>">
                                            <?php echo e($user->name); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <span class="<?php echo e($user->role == 1? 'badge badge-soft-primary' : ''); ?>">
                                        <?php echo e($user->email); ?>

                                        </span>
                                    </td>
                                    <td class="">
                                        <span class="badge bg-primary rounded-pill"><?php echo e($user->department->name); ?></span><br>
                                        <?php $__currentLoopData = $user->details->where('type', 1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge bg-primary rounded-pill"><?php echo e($item->department->name); ?></span><br>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                    <td class="">
                                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($user->role == 1 && $user->department_code == $department->code): ?>
                                                <span class="badge bg-success rounded-pill"><?php echo e($user->department->name); ?></span><br>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php $__currentLoopData = $user->details->where('type', 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge bg-success rounded-pill"><?php echo e($item->department->name); ?></span><br>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                    <td class="">
                                        <?php $__currentLoopData = $user->details->where('type', 2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge bg-secondary rounded-pill"><?php echo e($item->department->name); ?></span><br>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                    <td>
                                        <form method="post">
                                            <?php echo csrf_field(); ?>
                                            <label>
                                                <input name="user_id" type="hidden" value="<?php echo e($user->id); ?>">
                                                <select class="form-select form-select-sm" name="role">
                                                    <option <?php echo e($user->role == 0? 'selected' : ''); ?> value="0"></option>
                                                    <option <?php echo e($user->role == 1? 'selected' : ''); ?> value="1">Manager</option>
                                                </select>
                                            </label>
                                        </form>
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-<?php echo e($user->allowed?'success':'danger'); ?>">
                                            <?php echo e($user->allowed? "Approved" : "Not Approved"); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <?php if($user->allowed): ?>
                                            <a class="btn btn-danger btn-sm" href="<?php echo e(url('admin/allowed?id='.$user->id)); ?>">Disapprove</a>
                                        <?php else: ?>
                                            <a class="btn btn-primary btn-sm" href="<?php echo e(url('admin/allowed?id='.$user->id)); ?>">Approve</a>
                                        <?php endif; ?>
                                    </td>
                                    <td class="col text-center">
                                        <a href="javascript:remove_user(<?php echo e($user->id); ?>)">
                                            <i class="las la-trash text-danger" style="font-size: 22pt"></i>
                                        </a>
                                    </td>
                                </tr><!-- end -->
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->
                    </div>
                    <div class="align-items-center mt-xl-3 mt-4 justify-content-between d-flex">
                        <div class="flex-shrink-0">
                            <div class="text-muted">Showing <span class="fw-semibold"><?php echo e($users->count()); ?></span> of <span
                                    class="fw-semibold"> <?php echo e($users->total()); ?></span> Results
                            </div>
                        </div>
                        <?php echo $users->appends(['code' => $code, 'sort' => $sort, 'direction' => $direction])->links('vendor.pagination.custom')->render(); ?>

                    </div>

                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->



    <div class="modal fade bs-example-modal-center modal_remove_user" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json"
                               trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:120px;height:120px">
                    </lord-icon>
                    <div class="mt-0">
                        <div class="fs-15 mx-5">
                            <h4 class="mb-3">Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you Sure You want to Delete this User ?</p>
                        </div>
                    </div>
                    <div class="hstack gap-2 justify-content-center mt-3">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                        <form method="post" action="<?php echo e(url('admin/remove_user')); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="user_id" value="">
                            <button type="submit" href="javascript:void(0);" class="btn btn-danger">Yes, Delete It!</button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>

    <script>
        $('#sel_department').change(function () {
            $("#form_code").submit();
        });

        $('select[name="role"]').change(function () {
            $(this).parent().parent().submit();
        });

        function remove_user(user_id){
            $('input[name="user_id"]').val(user_id);
            $('.modal_remove_user').modal("show");
        }

        $(function () {})
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mchdmana/public_html/resources/views/admin/usermanagement.blade.php ENDPATH**/ ?>