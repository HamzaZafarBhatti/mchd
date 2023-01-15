<?php if($errors->any()): ?>
    <div class="mb-1">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="alert alert-danger alert-border-left alert-dismissible fade show mb-xl-0" role="alert">
                <i class="ri-error-warning-line me-3 align-middle fs-16"></i><strong>Danger</strong>
                - <?php echo e($error); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>
<?php /**PATH /home/mchdmana/public_html/resources/views/layouts/errors.blade.php ENDPATH**/ ?>