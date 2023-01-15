<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="<?php echo e(url('/')); ?>" class="logo logo-dark">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('assets/images/logo-sm.png')); ?>" alt="" height="38">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(URL::asset('assets/images/logo-dark.png')); ?>" alt="" height="33">
            </span>
        </a>

        <!-- Light Logo-->
        <a href="<?php echo e(url('/')); ?>" class="logo logo-light">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('assets/images/logo-sm.png')); ?>" alt="" height="38">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(URL::asset('assets/images/logo-light.png')); ?>" alt="" height="33">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title">
                    <span><?php echo app('translator')->get('translation.project_management'); ?></span>
                </li>
                <li class="nav-item">
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#dashboard" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-3-line"></i> <span><?php echo app('translator')->get('translation.dashboards'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown <?php echo e(Request::is(['dashboard/1', 'dashboard/2', 'dashboard/3', 'dashboard/4', 'dashboard/5', '/']) ? 'show' : ''); ?>"
                        id="dashboard">
                        <ul class="nav nav-sm flex-column">
                            <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e(Request::is('dashboard/' . $item->id) ? 'active' : ''); ?>"
                                        href="<?php echo e(url('dashboard/' . $item->id)); ?>">
                                        <?php echo e($item->name); ?>

                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </li>

                <?php if(auth()->guard()->check()): ?>
                    <?php ($current_user = auth()->user()); ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="<?php echo e(url('/kpi/charts')); ?>">
                            <i class="ri-flow-chart"></i> <span>KPI Charts</span>
                        </a>
                    </li>

                    <?php if(\App\Helper\Helper::kpiDataAddable($current_user)): ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="<?php echo e(url('/kpi/add_kpi_data')); ?>">
                                <i class="ri-keyboard-fill"></i> <span>KPI Data</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if($current_user->role != 2): ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link <?php echo e(Request::is([
                                'tasks/' . $current_user->department_code,
                                'biglist/' . $current_user->department_code,
                                'bigcreate/' . $current_user->department_code,
                            ])
                                ? 'active'
                                : ''); ?>"
                                href="<?php echo e(url('/tasks/' . $current_user->department_code)); ?>">
                                <i class="<?php echo e($current_user->department->icon); ?>"></i>
                                <span><?php echo e($current_user->department->name); ?></span>
                            </a>
                        </li>

                        <?php $__currentLoopData = $current_user->details()->groupBy('department_code')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($item->department->code != $current_user->department_code): ?>
                                <li class="nav-item">
                                    <a class="nav-link menu-link <?php echo e(Request::is('tasks/' . $item->department->code) ? 'active' : ''); ?>"
                                        href="<?php echo e(url('/tasks/' . $item->department->code)); ?>">
                                        <i class="<?php echo e($item->department->icon); ?>"></i>
                                        <span><?php echo e($item->department->name); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="nav-item">
                                <a class="nav-link menu-link <?php echo e(Request::is('tasks/' . $item->code) ? 'active' : ''); ?>"
                                    href="<?php echo e(url('/tasks/' . $item->code)); ?>">
                                    <i class="<?php echo e($item->icon); ?>"></i> <span><?php echo e($item->name); ?></span>
                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <li class="menu-title"><span><?php echo app('translator')->get('translation.admin_panel'); ?></span></li>
                        <li class="nav-item">
                            <a class="nav-link menu-link <?php echo e(Request::is('admin/chart') ? 'active' : ''); ?>"
                                href="<?php echo e(url('admin/chart')); ?>">
                                <i class="ri-pie-chart-2-line"></i> <span><?php echo app('translator')->get('translation.charts'); ?></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link <?php echo e(Request::is('admin/usermanagement') ? 'active' : ''); ?>"
                                href="<?php echo e(url('admin/usermanagement')); ?>">
                                <i class="ri-user-3-fill"></i> <span><?php echo app('translator')->get('translation.usermanagement'); ?></span>
                            </a>
                        </li>

                        <li class="menu-title">
                            <span><?php echo app('translator')->get('translation.kpi'); ?></span>
                        </li>
                        <li class="nav-item">
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="<?php echo e(url('/kpi/setting')); ?>">
                                <i class="ri-lock-password-fill"></i> <span>KPI Components</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="<?php echo e(url('/kpi/add')); ?>">
                                <i class="ri-key-2-fill"></i> <span>KPIs</span>
                            </a>
                        </li>

                        
                        
                        
                        
                        
                    <?php endif; ?>

                    <?php if($current_user->role == 1): ?>
                        <li class="menu-title">
                            <span><?php echo app('translator')->get('translation.kpi'); ?></span>
                        </li>
                        <li class="nav-item">
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="<?php echo e(url('/kpi/setting')); ?>">
                                <i class="ri-lock-password-fill"></i> <span>KPI Components</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="<?php echo e(url('/kpi/add')); ?>">
                                <i class="ri-key-2-fill"></i> <span>KPIs</span>
                            </a>
                        </li>
                    <?php endif; ?>

                <?php endif; ?>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>

<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
<?php /**PATH D:\xampp\htdocs\mchd-manager\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>