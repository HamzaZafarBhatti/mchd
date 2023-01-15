<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.projects'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('assets/libs/quill/quill.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(URL::asset('assets/libs/multi.js/multi.js.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('assets/libs/@tarekraafat/@tarekraafat.min.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>

    <?php $__env->slot('title'); ?> Projects <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
    <?php echo $__env->make('layouts.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <div class="row project-wrapper">
        <div class="col-xxl-12 col-lg-12 col-xl-12 col-md-12">
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4 class="card-title flex-grow-1 mb-0"><?php echo e($type); ?> Projects</h4>
                            <?php if($type === "All"): ?>
                                <a class="btn btn-danger btn-sm add-btn" data-bs-toggle="modal" data-bs-target="#createProjectModal"><i
                                        class="ri-add-line align-bottom me-1"></i> Create New Project</a>
                            <?php endif; ?>

                        </div><!-- end cardheader -->

                        <div class="card-header d-flex align-items-center">
                            <div class="search-box">
                                <form method="get">
                                    <input type="text" name="filter" value="<?php echo e($filter); ?>" class="form-control search bg-light border-light"
                                           placeholder="Search">
                                    <i class="ri-search-line search-icon"></i>
                                </form>
                            </div>
                        </div><!-- end cardheader -->

                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table class="table table-nowrap table-centered align-middle">
                                    <thead class="bg-light text-muted">
                                    <tr>
                                        <th scope="col"><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('name', 'Project Name'));?>
                                            <?php if($sort=='name'): ?>
                                                <?php if($direction=='asc'): ?>
                                                    <i class="las la-sort-alpha-up"></i>
                                                <?php else: ?>
                                                    <i class="las la-sort-alpha-down"></i>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </th>
                                        <th scope="col"><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('user.name', 'Project Lead'));?>
                                            <?php if($sort=='user.name'): ?>
                                                <?php if($direction=='asc'): ?>
                                                    <i class="las la-sort-alpha-up"></i>
                                                <?php else: ?>
                                                    <i class="las la-sort-alpha-down"></i>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </th>

                                        <th scope="col">Assignee</th>
                                        <th scope="col"><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('status', 'Status'));?></th>
                                        <th scope="col" style="width: 10%;"><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('end_date', 'Due Date'));?>
                                            <?php if($sort=='end_date'): ?>
                                                <?php if($direction=='asc'): ?>
                                                    <i class="las la-sort-up"></i>
                                                <?php else: ?>
                                                    <i class="las la-sort-down"></i>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </th>
                                    </tr><!-- end tr -->
                                    </thead><!-- thead -->

                                    <tbody>
                                    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="fw-medium">
                                                <a href="<?php echo e(url('project/'.$item->id)); ?>" class="text-reset">
                                                    <?php echo e($item->name); ?>

                                                </a>
                                            </td>
                                            <td>
                                                <?php echo \App\Helper\Helper::avatar($item->user->avatar, $item->user->name); ?>

                                                <a href="javascript: void(0);" class="text-reset">
                                                    <?php echo e($item->user->name); ?>

                                                </a>
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
                                            <td>
                                                <span class="badge badge-soft-<?php echo e(config('constants.status_color')[$item->status]); ?>">
                                                <?php echo e(config('constants.project_status')[$item->status]); ?>

                                                </span>
                                            </td>
                                            <td class="text-muted">
                                                <?php echo e($item->end_date); ?>

                                            </td>
                                        </tr><!-- end tr -->
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody><!-- end tbody -->
                                </table><!-- end table -->
                            </div>

                            <div class="align-items-center mt-xl-3 mt-4 justify-content-between d-flex">
                                <div class="flex-shrink-0">
                                    <div class="text-muted">Showing <span class="fw-semibold"><?php echo e($projects->count()); ?></span> of <span
                                            class="fw-semibold"> <?php echo e($projects->total()); ?></span> Results
                                    </div>
                                </div>
                                <?php echo $projects->appends(['filter' => $filter, 'sort' => $sort, 'direction' => $direction])->links('vendor.pagination.custom')->render(); ?>

                            </div>

                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->

            </div>

        </div>
    </div>

<div class="modal fade zoomIn" id="createProjectModal" tabindex="-1" aria-labelledby="createProjectModelLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-soft-info">
                <h5 class="modal-title" id="createProjectModelLabel">Create Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
            </div>
            <form action="<?php echo e(url('create_project')); ?>" method="post" class="needs-validation" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <div class="col-lg-12">
                                <label for="project_name" class="form-label">Project Name</label>
                                <input type="text" id="project_name" class="form-control" name="name" placeholder="Project name"
                                       required />
                            </div>
                            <!--end col-->
                            <div class="col-lg-12">
                                <div class="mt-3">
                                    <label for="definition_aims" class="form-label">Definition and aims</label>
                                    <input type="hidden" value="" name="definition_aims">
                                    <div style="height: 300px" id="definition_aims" class="snow-editor"></div>
                                </div>

                            </div>
                            <!--end col-->


                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 mt-3">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="text" id="start_date" class="form-control" name="start_date" data-provider="flatpickr"
                                           placeholder="Due date" required />
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 mt-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="text" id="end_date" class="form-control" name="end_date" data-provider="flatpickr"
                                           placeholder="Due date" required />
                                </div>
                                <!--end col-->
                                <div class="col-lg-6 col-md-6 col-sm-6 mt-3">
                                    <label for="project_status" class="form-label">Status</label>
                                    <select class="form-control" data-choices data-choices-search-false name="status" id="project_status">
                                        <option value="">Status</option>
                                        <?php $__currentLoopData = config('constants.project_status'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($key !== "all"): ?>
                                                <option value="<?php echo e($key); ?>"><?php echo e($val); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <!--end col-->

                                <div class="col-lg-6 col-md-6 col-sm-6 mt-3">
                                    <label for="file" class="form-label">Attach files</label>
                                    <input type="file" id="file" class="form-control" name="file" placeholder="Due date" required />
                                </div>
                            </div>


                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="col-lg-12">
                                <label for="multiselect-header" class="form-label">Assigned To</label>
                                <select
                                    required
                                    multiple="multiple"
                                    name="assignedTo[]"
                                    id="multiselect-header">
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>






















                            </div>
                        </div>


                    </div>
                    <!--end row-->
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 flex-wrap">
                        <button type="button" class="btn btn-light" id="close-modal"
                                data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" id="add-btn">Add Project</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <!-- apexcharts -->
    <script src="<?php echo e(URL::asset('/assets/libs/apexcharts/apexcharts.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/libs/@ckeditor/@ckeditor.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/libs/quill/quill.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/libs/multi.js/multi.js.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/libs/@tarekraafat/@tarekraafat.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/js/pages/dashboard-projects.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>

    <script>

        (function () {
            'use strict'

            // multiselector
            var multiSelectHeader = document.getElementById("multiselect-header");
            if (multiSelectHeader) {
                multi(multiSelectHeader, {
                    non_selected_header: "Candidate",
                    selected_header: "Assigned Users"
                });
            }

            // text editor
            var myEditor;
            var snowEditor = document.querySelectorAll(".snow-editor");

            if (snowEditor) {
                snowEditor.forEach(function (item) {
                    var snowEditorData = {};
                    var issnowEditorVal = item.classList.contains("snow-editor");

                    if (issnowEditorVal == true) {
                        snowEditorData.theme = 'snow', snowEditorData.modules = {
                            'toolbar': [[{
                                'font': []
                            }, {
                                'size': []
                            }], ['bold', 'italic', 'underline', 'strike'], [{
                                'color': []
                            }, {
                                'background': []
                            }], [{
                                'script': 'super'
                            }, {
                                'script': 'sub'
                            }], [{
                                'header': [false, 1, 2, 3, 4, 5, 6]
                            }, 'blockquote', 'code-block'], [{
                                'list': 'ordered'
                            }, {
                                'list': 'bullet'
                            }, {
                                'indent': '-1'
                            }, {
                                'indent': '+1'
                            }], ['direction', {
                                'align': []
                            }], ['link', 'image', 'video'], ['clean']]
                        };
                    }

                    myEditor = new Quill(item, snowEditorData);
                });
            } //buuble theme


            // form submit
            var form = document.querySelector('.needs-validation');
            var project_name = document.querySelector("#project_name");
            var start_date = document.querySelector("#start_date");
            var end_date = document.querySelector("#end_date");
            var project_status = document.querySelector("#project_status");
            var assignedTo = document.querySelector('select[name="assignedTo[]"]');
            var definition_aims = document.querySelector("input[name='definition_aims']");


            // submit
            document.querySelector("#add-btn").addEventListener("click", function () {
                definition_aims.value = myEditor.container.firstChild.innerHTML;
                if (project_name.value == ""){
                    notification("Please input project name.");
                    return;
                }
                if(definition_aims.value == "<p><br></p>"){;
                    notification("Please input definition and aims of the project.");
                    return;
                }
                if(start_date.value == ""){
                    notification("Please select start date.");
                    return;
                }
                if(start_date.value != "" && end_date.value != ""){
                    if(parseInt(start_date.value.replace(/-/g,""),10) > parseInt(end_date.value.replace(/-/g,""),10)){
                        notification("The end date has to be later regarding to start date");
                        return;
                    }
                }

                if (project_status.value == ""){
                    notification("Please select status of the project.");
                    return;
                }

                if (assignedTo.value == ""){
                    notification("Please select assignee.");
                    return;
                }
                form.submit();
            });
        })()
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mchdmana/public_html/resources/views/project/index.blade.php ENDPATH**/ ?>