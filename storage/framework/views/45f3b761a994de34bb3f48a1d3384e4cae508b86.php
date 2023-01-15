<?php if($message = Session::get('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong><?php echo $message; ?> </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if($message = Session::get('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><?php echo $message; ?> </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if($message = Session::get('warning')): ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong><?php echo $message; ?> </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>


<?php if($message = Session::get('info')): ?>
    <!-- Info Alert -->
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong><?php echo $message; ?> </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>







<?php /**PATH D:\xampp\htdocs\mchd-manager\resources\views/layouts/flash-message.blade.php ENDPATH**/ ?>