<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.create_task'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('assets/libs/dropzone/dropzone.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('assets/libs/quill/quill.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(URL::asset('assets/libs/@tarekraafat/@tarekraafat.min.css')); ?>" rel="stylesheet">

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.main_breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Sub Task
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Create Sub Task
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <?php echo $__env->make('layouts.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <form id="form" method="post" action="<?php echo e(url('subtask/create/'.$task_id)); ?>" enctype="multipart/form-data">
        <div class="row">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="task_id" value="<?php echo e($task_id); ?>">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="project-title-input">Sub Task Title</label>
                            <input name="name" type="text" class="form-control" id="project-title-input" placeholder="Enter Sub Task title">
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div>
                                    <label for="datepicker-start-input" class="form-label">StartDate</label>
                                    <input name="start_date" type="text" class="form-control" id="datepicker-start-input"
                                           placeholder="Enter due date" data-provider="flatpickr">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div>
                                    <label for="datepicker-deadline-input" class="form-label">EndDate</label>
                                    <input name="end_date" type="text" class="form-control" id="datepicker-deadline-input"
                                           placeholder="Enter due date" data-provider="flatpickr">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Attached files</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <p class="text-muted">Add Attached files here.</p>
                            <div class="fallback">
                                <input name="files[]" type="file" class="form-control" multiple="multiple">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header align-items-center d-flex border-bottom-dashed">
                        <h4 class="card-title mb-0 flex-grow-1">Members <span id="members_cnt" class="badge badge-soft-danger">0</span></h4>
                        <div class="flex-shrink-0">
                            <button onclick="open_invite_modal()" type="button" class="btn btn-soft-danger btn-sm">
                                <i class="ri-share-line me-1 align-bottom"></i> Invite Member
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div data-simplebar style="height: 235px;" class="mx-n3 px-3">
                            <div class="vstack gap-3" id="right_members_container"></div>
                            <!-- end list -->
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
                <div class="text-end mb-4">
                    <a href="javascript:history.back()" class="btn btn-danger w-sm">Back</a>
                    <?php if(\App\Helper\Helper::clinicSubTaskCreatable(auth()->user(), \App\Models\Task::findOrFail($task_id))): ?>
                    <button type="button" class="btn btn-success w-sm" onclick="create_task()">Create</button>
                    <?php endif; ?>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </form>

    <!-- Modal -->
    <div class="modal fade" id="inviteMembersModal" tabindex="-1" aria-labelledby="inviteMembersModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-3 ps-4 bg-soft-success">
                    <h5 class="modal-title" id="inviteMembersModalLabel">Members</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="search-box mb-3">
                        <input id="member_search" type="text" class="form-control bg-light border-light" placeholder="Search here...">
                        <i class="ri-search-line search-icon"></i>
                    </div>

                    <div class="mb-4 d-flex align-items-center">
                        <div class="me-2">
                            <h5 class="mb-0 fs-13">Members :</h5>
                        </div>
                        <div class="avatar-group justify-content-center members_on_modal"></div>
                    </div>
                    <div class="mx-n4 px-4" data-simplebar style="max-height: 225px;">
                        <div class="vstack gap-3" id="members_container">
                            <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-light w-xs" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success w-xs" onclick="invite()">Invite</button>
                </div>
            </div>
            <!-- end modal-content -->
        </div>
        <!-- modal-dialog -->
    </div>
    <!-- end modal -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('assets/libs/@ckeditor/@ckeditor.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/libs/quill/quill.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/libs/@tarekraafat/@tarekraafat.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/libs/dropzone/dropzone.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/js/pages/project-create.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script-bottom'); ?>
    <script>
        let candidate_user_list = <?php echo json_encode($members, 15, 512) ?>;
        let user_list = [];

        function add_user(obj, i){
            var user = candidate_user_list[i];
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


        function add_leader_at_top_modal(user){
            $('.members_on_modal').append(avatar(user));
        }

        function delete_leader_at_top_modal(user){
            $('.members_on_modal').empty();
            for (var i = 0; i < user_list.length; i++)
                $('.members_on_modal').append(avatar(user_list[i]));
        }

        function avatar(user, size = 'avatar-xs'){
            let clientNameBothLetters = user.name.split(" ")[0][0];
            if (user.name.split(" ").length > 1)
                clientNameBothLetters = user.name.split(" ")[0][0]
                    + user.name.split(" ")[user.name.split(" ").length - 1][0];

            let leader = '<a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"\
                            data-bs-trigger="hover" data-bs-placement="top" title="Brent Gonzalez">\
                                <div class="'+ size +'">\
                                    <img src="<?php echo e(URL::asset('public/images/')); ?>/'+ user.avatar +'" alt="" class="rounded-circle img-fluid">\
                                </div>\
                          </a>';

            if (user.avatar === 'user_default.jpg')
                leader = '<a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"\
                            data-bs-trigger="hover" data-bs-placement="top" title="Brent Gonzalez">\
                                <div class="avatar-xs">\
                                    <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' + user.name + '" class="'+ size +' me-0 d-inline-block">\
                                    <div class="avatar-title rounded-circle bg-secondary text-white text-uppercase">' + clientNameBothLetters + '</div>\
                                </div>\
                                </div>\
                          </a>';
            return leader;
        }


        function invite(){
            update_right_members_container(user_list);
            $('#inviteMembersModal').modal('hide');
        }


        function update_right_members_container(user_list){
            $('#members_cnt').text(user_list.length);
            $('#right_members_container').empty();
            $.each(user_list, function (i, item){
                var item_html = '<div class="d-flex align-items-center">\
                                 '+ avatar(item) +' \
                                <div class="flex-grow-1">\
                                    <h5 class="fs-13 mb-0"><a href="#" class="text-body d-block">'+ item.name +'</a></h5>\
                                </div>\
                                <div class="flex-shrink-0">\
                                    <div class="d-flex align-items-center gap-1">\
                                        <div class="dropdown">\
                                            <button class="btn btn-icon btn-sm fs-16 text-muted dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">\
                                            <i class="ri-more-fill"></i></button>\
                                            <ul class="dropdown-menu">\
                                                <li><a class="dropdown-item" href="javascript:delete_user('+ item.id +');"><i class="ri-delete-bin-5-fill text-muted me-2 align-bottom"></i>Delete</a></li>\
                                            </ul>\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>';

                $('#right_members_container').append(item_html);
            });
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


        function open_invite_modal(){
            update_modal(user_list);
            $('#inviteMembersModal').modal('show');
        }

        function update_modal(user_list){
            $('.members_on_modal').empty();
            $.each(user_list, function (i, item){
                $('.members_on_modal').append(avatar(item));
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

        function delete_user(id){
            user_list = jQuery.grep(user_list, function(user) {
                return user.id != id;
            });
            update_right_members_container(user_list);
        }

        function create_task(){
            var big_project_name = $("input[name='name']").val();
            var start_date = $("input[name='start_date']").val();
            var end_date = $("input[name='end_date']").val();
            if (big_project_name === ""){
                notification("Please input project name.");
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
            $('#form').submit();
        }


        $(document).ready(function () {
            // search on modal
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
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mchdmana/public_html/resources/views/subtask/create.blade.php ENDPATH**/ ?>