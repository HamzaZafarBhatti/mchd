<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="<?php echo e(url("/")); ?>" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="<?php echo e(URL::asset('assets/images/logo-sm.png')); ?>" alt="" height="35">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo e(URL::asset('assets/images/logo-dark.png')); ?>" alt="" height="30">
                        </span>
                    </a>

                    <a href="<?php echo e(url("/")); ?>" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="<?php echo e(URL::asset('assets/images/logo-sm.png')); ?>" alt="" height="35">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo e(URL::asset('assets/images/logo-light.png')); ?>" alt="" height="30">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->




























































































            </div>

            <div class="d-flex align-items-center">




















































































































































































































































































































































                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>




















































































































































































































































                <?php if(auth()->guard()->guest()): ?>
                    <a  class="btn btn-outline-primary ms-2" href="<?php echo e(route('login')); ?>">Login</a>
                    <a  class="btn btn-outline-primary ms-2" href="<?php echo e(route('register')); ?>">Register</a>
                <?php endif; ?>

                <?php if(auth()->guard()->check()): ?>
                    <div class="dropdown ms-sm-3 header-item topbar-user">
                        <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <?php echo \App\Helper\Helper::topbar_avatar(Auth::user()->avatar, Auth::user()->name); ?>

                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?php echo e(Auth::user()->name); ?></span>
                            </span>
                        </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <h6 class="dropdown-header">Welcome!</h6>

                            <a class="dropdown-item" href="<?php echo e(url('setting')); ?>">
                                <i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Settings
                                </span>
                            </a>

                            <a class="dropdown-item " href="javascript:void(null);"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    class="bx bx-power-off font-size-16 align-middle me-1"></i> <span
                                    key="t-logout"><?php echo app('translator')->get('translation.logout'); ?></span></a>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                <?php echo csrf_field(); ?>
                            </form>

                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</header>
<?php /**PATH /home/mchdmana/public_html/resources/views/layouts/topbar.blade.php ENDPATH**/ ?>