<?php echo $__env->yieldContent('css'); ?>
<!-- Layout config Js -->
<script src="<?php echo e(URL::asset('assets/js/layout.js')); ?>"></script>
<!-- Bootstrap Css -->
<link href="<?php echo e(URL::asset('assets/css/bootstrap.min.css')); ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="<?php echo e(URL::asset('assets/css/icons.min.css')); ?>" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="<?php echo e(URL::asset('assets/css/app.min.css')); ?>" id="app-style" rel="stylesheet" type="text/css" />
<!-- custom Css-->
<link href="<?php echo e(URL::asset('assets/css/custom.min.css')); ?>" id="app-style" rel="stylesheet" type="text/css" />
<link href="<?php echo e(URL::asset('assets/libs/quill/quill.min.css')); ?>" rel="stylesheet" type="text/css" />

<style>
    #overlay{
        position: fixed;
        top: 0;
        z-index: 10000;
        width: 100%;
        height:100%;
        display: none;
        background: rgba(0,0,0,0.6);
    }
    .cv-spinner {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .spinner {
        width: 40px;
        height: 40px;
        border: 4px #ddd solid;
        border-top: 4px #2e93e6 solid;
        border-radius: 50%;
        animation: sp-anime 0.8s infinite linear;
    }
    @keyframes sp-anime {
        100% {
            transform: rotate(360deg);
        }
    }
    .is-hide{
        display:none;
    }
</style>
<?php echo $__env->yieldContent('css_bottom'); ?>

<?php /**PATH D:\xampp\htdocs\mchd-manager\resources\views/layouts/head-css.blade.php ENDPATH**/ ?>