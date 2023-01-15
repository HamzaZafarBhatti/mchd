<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.projects'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('assets/libs/quill/quill.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(URL::asset('assets/libs/multi.js/multi.js.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('assets/libs/@tarekraafat/@tarekraafat.min.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        
        <?php $__env->slot('title'); ?><?php echo e($department->name); ?> Tasks <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <?php echo $__env->make('layouts.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <div class="row project-wrapper">
        <div class="col-xxl-12 col-lg-12 col-xl-12 col-md-12">
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4 class="card-title flex-grow-1 mb-0"><?php echo e($department->name); ?> Tasks</h4>

                            <?php if(\App\Helper\Helper::otherTaskCreatable($current_user, $code)): ?>
                                <button class="btn btn-danger btn-sm add-btn" data-bs-toggle="modal"
                                        data-bs-target="#createProjectModal" onclick="open_invite_modal()"><i
                                        class="ri-add-line align-bottom me-1"></i> Create New Task</button>
                            <?php endif; ?>

                        </div><!-- end cardheader -->

                        <div class="card-header d-flex align-items-center">
                            <div class="search-box">
                                <form method="get">
                                    <input type="text" name="filter" value="<?php echo e($filter); ?>"
                                           class="form-control search bg-light border-light"
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
                                        <th scope="col"><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('name', 'Task Title'));?>
                                            <?php if($sort=='name'): ?>
                                                <?php if($direction=='asc'): ?>
                                                    <i class="las la-sort-alpha-up"></i>
                                                <?php else: ?>
                                                    <i class="las la-sort-alpha-down"></i>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </th>
                                        <th class="col">Manager</th>
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
                                                <a href="<?php echo e(url('tasks/detail/'.$item->id)); ?>" class="text-reset">
                                                    <?php echo e(\App\Helper\Helper::limitString($item->name, 25)); ?>

                                                </a>
                                            </td>
                                            <td>
                                                <?php echo \App\Helper\Helper::avatar($item->leader->avatar, $item->leader->name, 'avatar-xxs', 11, $item->leader_id == auth()->user()->getAuthIdentifier()); ?>

                                            </td>
                                            <td>
                                                <div class="avatar-group flex-nowrap">
                                                    <?php $__currentLoopData = $item->assignUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="avatar-group-item">
                                                            <a href="javascript: void(0);" class="d-inline-block">
                                                                <?php echo \App\Helper\Helper::avatar($assignUser->avatar, $assignUser->name, 'avatar-xxs', 11, $assignUser->id == auth()->user()->getAuthIdentifier()); ?>

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
                                    <div class="text-muted">Showing <span
                                            class="fw-semibold"><?php echo e($projects->count()); ?></span> of <span
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
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-soft-info">
                    <h5 class="modal-title" id="createProjectModelLabel">Create Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                <form id="create_task" action="<?php echo e(url('tasks/create')); ?>" method="post" class="needs-validation" enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="department_code" value="<?php echo e($code); ?>">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="col-lg-12">
                                    <label for="project_name" class="form-label">Task Title</label>
                                    <input type="text" id="project_name" class="form-control" name="name"
                                           placeholder="Task Title"
                                           required/>
                                </div>
                                <!--end col-->
                                <div class="col-lg-12 mt-3">
                                    <label for="multiselect-header" class="form-label">Assigned To</label>
                                    <div class="p-3 border border-1 rounded">
                                        <div class="search-box mb-3">
                                            <input id="member_search" type="text" class="form-control bg-light border-light" placeholder="Search here...">
                                            <i class="ri-search-line search-icon"></i>
                                        </div>

                                        <div class="mb-4 d-flex align-items-center">
                                            <div class="me-2">
                                                <h5 class="mb-0 fs-13">Members :</h5>
                                            </div>
                                            <div class="avatar-group justify-content-center leaders_on_modal"></div>
                                        </div>
                                        <div class="mx-n4 px-4" data-simplebar style="max-height: 225px;">
                                            <div class="vstack gap-3" id="members_container">
                                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="d-flex align-items-center member_item">
                                                        <div class="avatar-xs flex-shrink-0 me-3">
                                                            <?php echo \App\Helper\Helper::avatar($item->avatar, $item->name, "avatar-xs"); ?>

                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="fs-13 mb-0"><a href="#" class="text-body d-block name"><?php echo e($item->name); ?></a>
                                                            </h5>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <button type="button" class="btn btn-light btn-sm" onclick="add_user(<?php echo e(json_encode($item)); ?>)">Add</button>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                            <!-- end list -->
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 mt-3">
                                        <label for="start_date" class="form-label">Start Date</label>
                                        <input type="text" id="start_date" class="form-control" name="start_date"
                                               data-provider="flatpickr"
                                               placeholder="Due date" required/>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 mt-3">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <input type="text" id="end_date" class="form-control" name="end_date"
                                               data-provider="flatpickr"
                                               placeholder="Due date" required/>
                                    </div>
                                    <!--end col-->
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 flex-wrap">
                            <button type="button" class="btn btn-light" id="close-modal"
                                    data-bs-dismiss="modal">Close
                            </button>
                            <button type="button" class="btn btn-success" id="add-btn">Post</button>
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

<?php $__env->stopSection(); ?>


<?php $__env->startSection('script-bottom'); ?>
    <script>
        let user_list = [];
        let candidate_user_list = <?php echo json_encode($users, 15, 512) ?>;
        { // invite leader
            function add_user(obj, i){
                var user = candidate_user_list[i];
                console.log(user);
                if (!push_user(user)){
                    add_leader_at_top_modal(user);
                    $(obj).text("Remove");
                }else {
                    delete_leader_at_top_modal(user);
                    $(obj).text("Add");
                }
            }

            function push_user(user){
                var status = false;
                for(var i=0; i<user_list.length; i++) {
                    var id = user_list[i].id;
                    if (id == user.id) {
                        status = true;
                        break;
                    }
                }
                if (!status)
                    user_list.push(user);
                else{ // if exists
                    Utils.removeByAttr(user_list, 'id', user.id);
                }
                return status;
            }


            function delete_leader_at_top_modal(user){
                $('.leaders_on_modal').empty();
                for (var i = 0; i < user_list.length; i++)
                    $('.leaders_on_modal').append(avatar(user_list[i]));
            }

            function html_candidate_item(candidate, text, i){
                var html = '<div class="d-flex align-items-center member_item">\
                <div class="avatar-xs flex-shrink-0 me-3">\
                    '+ avatar(candidate) +'\
                </div>\
                <div class="flex-grow-1">\
                    <h5 class="fs-13 mb-0"><a href="#" class="text-body d-block name"> '+ candidate.name +'</a>\
                    </h5>\
                </div>\
                <div class="flex-shrink-0">\
                    <button type="button" class="btn btn-light btn-sm" onclick="add_user(this, '+ i +')">'+ text +'</button>\
                </div>\
            </div>';
                return html;
            }

            function update_modal(user_list){

                $('.leaders_on_modal').empty();
                $.each(user_list, function (i, item){
                    $('.leaders_on_modal').append(avatar(item));
                });


                $('#members_container').empty();
                $.each(candidate_user_list,function (i, item){
                    var isExited = false;
                    for (var j = 0; j < user_list.length; j++){
                        if (user_list[j].id === item.id){
                            isExited = true;
                            break;
                        }
                    }
                    if (isExited){
                        $('#members_container').append(html_candidate_item(item, "Remove", i));
                    }else
                        $('#members_container').append(html_candidate_item(item, "Add", i));
                });

            }

            function add_leader_at_top_modal(user){
                $('.leaders_on_modal').append(avatar(user));
            }

            function avatar(user, size = 'avatar-xs'){
                let clientNameBothLetters = user.name.split(" ")[0][0];
                if (user.name.split(" ").length > 1)
                    clientNameBothLetters = user.name.split(" ")[0][0]
                        + user.name.split(" ")[user.name.split(" ").length - 1][0];

                let leader = '<a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"\
                            data-bs-trigger="hover" data-bs-placement="top" title="'+ user.name +'">\
                                <div class="'+ size +'">\
                                    <img src="<?php echo e(URL::asset('public/images/')); ?>/'+ user.avatar +'" alt="" class="rounded-circle img-fluid">\
                                </div>\
                          </a>';

                if (user.avatar === 'user_default.jpg')
                    leader = '<a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"\
                            data-bs-trigger="hover" data-bs-placement="top" title="'+ user.name +'">\
                                <div class="avatar-xs">\
                                    <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' + user.name + '" class="'+ size +' me-0 d-inline-block">\
                                    <div class="avatar-title rounded-circle bg-secondary text-white text-uppercase">' + clientNameBothLetters + '</div>\
                                </div>\
                                </div>\
                          </a>';
                return leader;
            }

            function open_invite_modal(){
                update_modal(user_list);
                $('#inviteMembersModal').modal('show');
            }

            function invite(){
                if (user_list.length === 0){
                    notification("Please select assignee.");
                    return;
                }
                $.each(user_list, function (i, item) {
                    var html_userlist = $("<input>")
                        .attr("type", "hidden")
                        .attr("name", "assignedTo[]").val(item.id);
                    $('#form').append(html_userlist);
                });
                $("#form").submit();
            }
        }

        {// search
            $("#member_search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#members_container .member_item").css("display", function() {
                    if ($(this).find('a.name').text().toLowerCase().indexOf(value) > -1){
                        $(this).removeClass("d-none").addClass("d-flex");
                    }
                    else{
                        $(this).removeClass("d-flex").addClass("d-none");
                    }
                });
            });
        }


        {// submit
            $('#add-btn').click(function () {
                let name = $('input[name="name"]').val();
                let start_date = $('input[name="start_date"]').val();
                let end_date = $('input[name="end_date"]').val();

                if (name === ""){
                    notification("Please input task title");
                    return;
                }

                if (user_list.length == 0){
                    notification("Please assign users.");
                    return;
                }


                if (start_date === ""){
                    notification("Please select start date.");
                    return;
                }

                if(start_date !== "" && end_date !== ""){
                    if(parseInt(start_date.replace(/-/g,""),10) > parseInt(end_date.replace(/-/g,""),10)){
                        notification("The end date has to be later regarding to start date");
                        return;
                    }
                }

                $.each(user_list, function (i, item) {
                    let html_userlist = $("<input>")
                        .attr("type", "hidden")
                        .attr("name", "assignedTo[]").val(item.id);
                    $('#create_task').append(html_userlist);
                });

                $('#create_task').submit();
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\mchd-manager\resources\views/other/tasks.blade.php ENDPATH**/ ?>