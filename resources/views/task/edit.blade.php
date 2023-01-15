@extends('layouts.master')
@section('title')
    @lang('translation.create_big_project')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/quill/quill.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/@tarekraafat/@tarekraafat.min.css') }}" rel="stylesheet">

@endsection
@section('content')
    @component('components.main_breadcrumb')
        @slot('li_1')
            Task
        @endslot
        @slot('title')
            Edit Task
        @endslot
    @endcomponent

    @include('layouts.errors')
    @include('layouts.flash-message')

    <form id="form" method="post" action="{{url('task/edit/'.$task->id)}}" enctype="multipart/form-data">
        <input type="hidden" value="{{$task->id}}" name="id">
        <div class="row">
            @csrf
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="project-title-input">Project Title</label>
                            <input name="name" type="text" class="form-control" id="project-title-input" value="{{$task->name}}" placeholder="Enter project title">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Task Description</label>
                            <div class="snow-editor" id="ckeditor-classic" style="height: 300px">{!! $task->description !!}</div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div>
                                    <label for="datepicker-start-input" class="form-label">StartDate</label>
                                    <input name="start_date" value="{{$task->start_date}}" type="text" class="form-control" id="datepicker-start-input"
                                           placeholder="Enter due date" data-provider="flatpickr">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div>
                                    <label for="datepicker-deadline-input" class="form-label">EndDate</label>
                                    <input name="end_date" value="{{$task->end_date}}" type="text" class="form-control" id="datepicker-deadline-input"
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
                    {{--                <button type="submit" class="btn btn-secondary w-sm">Draft</button>--}}
                    <button type="button" class="btn btn-success w-sm" onclick="edit()">Edit</button>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </form>

@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/quill/quill.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/@tarekraafat/@tarekraafat.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/project-create.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection

@section('script-bottom')
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
@endsection
