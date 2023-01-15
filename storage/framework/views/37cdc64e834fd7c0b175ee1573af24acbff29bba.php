<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.projects'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection("css_bottom"); ?>

<link rel="stylesheet" href="<?php echo e(asset('assets/libs/editable-table/editable-table.css')); ?>">
<link href="<?php echo e(asset('assets/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css')); ?>" rel="stylesheet"/>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.main_breadcrumb'); ?>
        <?php $__env->slot('title'); ?> Kpi Data <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_1'); ?> Admin panel <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <?php echo $__env->make('layouts.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-xs-12" id="kpi_data_container"></div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('assets/libs/editable-table/babel-external-helpers.js')); ?>"></script>

    <script src="<?php echo e(asset('assets/libs/editable-table/mindmup-editabletable.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/libs/editable-table/Plugin.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/libs/editable-table/editable-table.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script-bottom'); ?>
    <script>
        $(document).ready(function () {
            $(document).ajaxSend(function() {
                $("#overlay").fadeIn(50);
            });
            $.ajax({
                url: "<?php echo e(url('kpi/get_kpi_data')); ?>",
                method: "post",
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                },
                success: function (response) {
                    $('#kpi_data_container').empty();
                    $('#kpi_data_container').html(response);

                },
                error: function (response){

                },
                failure: function (response){

                }
            }).done(function () {
                setTimeout(function(){
                    $("#overlay").fadeOut(200);
                },500);
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\mchd-manager\resources\views/admin/kpi/add_kpi_data.blade.php ENDPATH**/ ?>