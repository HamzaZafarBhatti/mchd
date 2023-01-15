<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.settings'); ?>
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
                        <form method="post" enctype="multipart/form-data" action="<?php echo e(url('change_avatar')); ?>">
                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                            <img src="<?php if($user->avatar != ''): ?> <?php echo e(URL::asset('public/images/'.$user->avatar)); ?><?php else: ?><?php echo e(URL::asset('assets/images/users/avatar-1.jpg')); ?> <?php endif; ?>"
                                 class="  rounded-circle avatar-xl img-thumbnail user-profile-image"
                                 alt="user-profile-image">

                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                    <?php echo csrf_field(); ?>
                                    <input id="profile-img-file-input" required name="change_avatar" type="file" class="profile-img-file-input">
                                    <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                    <span class="avatar-title rounded-circle bg-light text-body">
                                        <i class="ri-camera-fill"></i>
                                    </span>
                                    </label>
                            </div>
                        </div>
                        <h5 class="fs-16 mb-1"><?php echo e($user->name); ?></h5>
                        <p class="text-muted mb-0"><?php echo e($user->department->name); ?></p>
                        <?php if($user->boss): ?>
                            <p class="text-muted mb-0">
                                <span class="badge badge-soft-info">
                                    Boss
                                </span>
                            </p>
                        <?php endif; ?>
                        <div class="col-lg-12 mt-4">
                            <div class="hstack gap-2 justify-content-center">
                                <button type="submit" class="btn btn-primary btn-sm">Change</button>
                                <button type="button" class="btn btn-soft-success btn-sm cancel_avatar">Cancel</button>
                            </div>
                        </div>
                        </form>
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
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                <i class="far fa-user"></i>
                                Change Password
                            </a>
                        </li>






                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                            <form action="javascript:void(0);">
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








                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>
                        </div>
                        <!--end tab-pane-->
                        <div class="tab-pane" id="changePassword" role="tabpanel">
                            <form action="<?php echo e(url('updatePassword')); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <div class="row g-2">
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="oldpasswordInput" class="form-label">Old
                                                Password*</label>
                                            <input type="password" class="form-control" id="oldpasswordInput"
                                                  name="old_password" placeholder="Enter current password" required>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="newpasswordInput" class="form-label">New
                                                Password*</label>
                                            <input type="password" class="form-control" id="newpasswordInput"
                                                  name="password" placeholder="Enter new password" required>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="confirmpasswordInput" class="form-label">Confirm
                                                Password*</label>
                                            <input type="password" class="form-control" id="confirmpasswordInput"
                                                  name="password_confirmation" placeholder="Confirm password" required>
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-lg-12">
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-success">Change
                                                Password</button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>
                        </div>
                        <!--end tab-pane-->
                        <div class="tab-pane" id="notification" role="tabpanel">



                        </div>
                        <!--end tab-pane-->
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('assets/js/pages/profile-setting.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mchdmana/public_html/resources/views/setting/setting.blade.php ENDPATH**/ ?>