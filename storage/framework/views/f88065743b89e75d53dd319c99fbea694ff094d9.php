<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.create_big_project'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('assets/libs/dropzone/dropzone.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('assets/libs/quill/quill.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(URL::asset('assets/libs/@tarekraafat/@tarekraafat.min.css')); ?>" rel="stylesheet">

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.main_breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Task
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Edit Task
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <?php echo $__env->make('layouts.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <form id="form" method="post" action="<?php echo e(url('task/edit/'.$task->id)); ?>" enctype="multipart/form-data">
        <input type="hidden" value="<?php echo e($task->id); ?>" name="id">
        <div class="row">
            <?php echo csrf_field(); ?>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="project-title-input">Project Title</label>
                            <input name="name" type="text" class="form-control" id="project-title-input" value="<?php echo e($task->name); ?>" placeholder="Enter project title">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Task Description</label>
                            <div class="snow-editor" id="ckeditor-classic" style="height: 300px"><?php echo $task->description; ?></div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div>
                                    <label for="datepicker-start-input" class="form-label">StartDate</label>
                                    <input name="start_date" value="<?php echo e($task->start_date); ?>" type="text" class="form-control" id="datepicker-start-input"
                                           placeholder="Enter due date" data-provider="flatpickr">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div>
                                    <label for="datepicker-deadline-input" class="form-label">EndDate</label>
                                    <input name="end_date" value="<?php echo e($task->end_date); ?>" type="text" class="form-control" id="datepicker-deadline-input"
                                           placeholder="Enter due date" data-provider="flatpickr">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
                <div class="text-end mb-4">
                    <a href="javascript:history.back()" class="btn btn-danger w-sm">Back</a>
                    
                    <button type="button" class="btn btn-success w-sm" onclick="edit()">Edit</button>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </form>

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
        var myEditor;


        function edit(){
            var big_project_name = $("input[name='name']").val();
            var start_date = $("input[name='start_date']").val();
            var end_date = $("input[name='end_date']").val();
            var description = myEditor.container.firstChild.innerHTML;

            if (big_project_name === ""){
                notification("Please input project name.");
                return;
            }

            if (description === "<p><br></p>"){
                notification("Please input description of the project.");
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

            var html_description = $("<input>")
                .attr("type", "hidden")
                .attr("name", "description").val(description);
            $('#form').append(html_description);

            $('#form').submit();
        }


        $(document).ready(function () {
            // text editor
            var snowEditor = document.querySelector(".snow-editor");
            var snowEditorData = {};
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
            myEditor = new Quill(snowEditor, snowEditorData);

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mchdmana/public_html/resources/views/task/edit.blade.php ENDPATH**/ ?>