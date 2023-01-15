<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.projects'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.main_breadcrumb'); ?>
        <?php $__env->slot('title'); ?> KPI Settings  <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_1'); ?> Admin panel <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <?php echo $__env->make('layouts.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row">
        <div class="col-md-6 col-lg-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Groups</h4>
                    <div class="flex-shrink-0">

                    </div>
                </div>

                <form action="<?php echo e(url('kpi/add_group')); ?>" method="post">
                    <div class="card-header align-items-center d-flex">
                        <?php echo csrf_field(); ?>
                        <div class="input-group">
                            <input name="name" type="text" class="form-control" required>
                            <button class="btn btn-outline-success" type="submit">Add Group</button>
                        </div>
                    </div>
                </form>

                <div class="card-body">
                    <ul class="list-group">
                        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item d-flex align-items-center">
                                <div class="flex-grow-1">
                                    - <?php echo e($item->name); ?>

                                </div>
                                <div class="flex-shrink-0">
                                    <a href="javascript:edit_group(<?php echo e(json_encode($item)); ?>)">
                                        <i style="font-size: 16pt" class="ri-edit-2-fill text-success px-2"></i>
                                    </a>
                                    <a href="javascript:delete_group(<?php echo e(json_encode($item)); ?>)">
                                        <i style="font-size: 16pt" class="ri-delete-bin-6-fill text-danger px-2"></i>
                                    </a>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Units</h4>
                    <div class="flex-shrink-0">

                    </div>
                </div>

                <form action="<?php echo e(url('kpi/add_unit')); ?>" method="post">
                    <div class="card-header align-items-center d-flex">
                        <?php echo csrf_field(); ?>
                        <div class="input-group">
                            <input name="name" type="text" class="form-control" required>
                            <button class="btn btn-outline-success" type="submit">Add Unit</button>
                        </div>
                    </div>
                </form>

                <div class="card-body">
                    <ul class="list-group">
                        <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item d-flex align-items-center">
                                <div class="flex-grow-1">
                                    - <?php echo e($item->name); ?>

                                </div>
                                <div class="flex-shrink-0">
                                    <a href="javascript:edit_unit(<?php echo e(json_encode($item)); ?>)">
                                        <i style="font-size: 16pt" class="ri-edit-2-fill text-success px-2"></i>
                                    </a>
                                    <a href="javascript:delete_unit(<?php echo e(json_encode($item)); ?>)">
                                        <i style="font-size: 16pt" class="ri-delete-bin-6-fill text-danger px-2"></i>
                                    </a>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="edit_group" tabindex="-1" aria-labelledby="edit_group"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-3 ps-4 bg-soft-success">
                    <h5 class="modal-title" id="edit_group">Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(url('kpi/edit_gu')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body p-4">
                        <input name="type" type="hidden">
                        <input name="id" type="hidden">
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light w-xs" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success w-xs" onclick="">Edit</button>
                    </div>
                </form>
            </div>
            <!-- end modal-content -->
        </div>
        <!-- modal-dialog -->
    </div>
    <!-- end modal -->



    <div id="delete_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json"
                               trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:120px;height:120px">
                    </lord-icon>
                    <div class="mt-0">
                        <div class="fs-15 mx-5">
                            <h4 class="mb-3">Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you Sure You want to Delete this item ?</p>
                            <p class="text-muted mx-4 mb-0">All kpis related with this item will be removed. Please confirm again.</p>
                        </div>
                    </div>
                    <div class="hstack gap-2 justify-content-center mt-3">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                        <form method="post" action="<?php echo e(url('kpi/delete_gu')); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="type" value="">
                            <input type="hidden" name="id" value="">
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script-bottom'); ?>
    <script>
        function setDataEditModal(type, id, name){
            $('input[name="type"]').val(type);
            $('input[name="id"]').val(id);
            $('input[name="name"]').val(name);
        }

        function setDataDeleteModal(type, id){
            $('#delete_modal input[name="type"]').val(type);
            $('#delete_modal input[name="id"]').val(id);
        }


        function edit_unit(group) {
            const type = 2;
            const {id, name} = group;
            setDataEditModal(type, id, name);
            $('#edit_group').modal("show");
        }

        function delete_unit(group){
            const type = 2;
            const {id} = group;
            setDataDeleteModal(type, id);
            $("#delete_modal").modal("show");
        }

        function edit_group(group) {
            const type = 1;
            const {id, name} = group;
            setDataEditModal(type, id, name);
            $('#edit_group').modal("show");
        }

        function delete_group(group){
            const type = 1;
            const {id} = group;
            setDataDeleteModal(type, id);
            $("#delete_modal").modal("show");
        }



    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mchdmana/public_html/resources/views/admin/kpi/setting.blade.php ENDPATH**/ ?>