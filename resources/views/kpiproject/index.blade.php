@extends('layouts.master')
@section('title') @lang('translation.projects') @endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/quill/quill.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/multi.js/multi.js.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/@tarekraafat/@tarekraafat.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    @component('components.breadcrumb')
{{--    @slot('li_1') Project @endslot--}}
    @slot('title') Projects @endslot
@endcomponent
    @include('layouts.errors')
    @include('layouts.flash-message')


    <div class="row project-wrapper">
        <div class="col-xxl-12 col-lg-12 col-xl-12 col-md-12">
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4 class="card-title flex-grow-1 mb-0">{{$type}} Projects</h4>
                            @if($type === "All")
                                <a class="btn btn-danger btn-sm add-btn" data-bs-toggle="modal" data-bs-target="#createProjectModal"><i
                                        class="ri-add-line align-bottom me-1"></i> Create New Project</a>
                            @endif

                        </div><!-- end cardheader -->

                        <div class="card-header d-flex align-items-center">
                            <div class="search-box">
                                <form method="get">
                                    <input type="text" name="filter" value="{{$filter}}" class="form-control search bg-light border-light"
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
                                        <th scope="col">@sortablelink('name', 'Project Name')
                                            @if($sort=='name')
                                                @if($direction=='asc')
                                                    <i class="las la-sort-alpha-up"></i>
                                                @else
                                                    <i class="las la-sort-alpha-down"></i>
                                                @endif
                                            @endif
                                        </th>
                                        <th scope="col">@sortablelink('user.name', 'Project Lead')
                                            @if($sort=='user.name')
                                                @if($direction=='asc')
                                                    <i class="las la-sort-alpha-up"></i>
                                                @else
                                                    <i class="las la-sort-alpha-down"></i>
                                                @endif
                                            @endif
                                        </th>
{{--                                        <th scope="col">Progress</th>--}}
                                        <th scope="col">Assignee</th>
                                        <th scope="col">@sortablelink('status', 'Status')</th>
                                        <th scope="col" style="width: 10%;">@sortablelink('end_date', 'Due Date')
                                            @if($sort=='end_date')
                                                @if($direction=='asc')
                                                    <i class="las la-sort-up"></i>
                                                @else
                                                    <i class="las la-sort-down"></i>
                                                @endif
                                            @endif
                                        </th>
                                    </tr><!-- end tr -->
                                    </thead><!-- thead -->

                                    <tbody>
                                    @foreach($projects as $item)
                                        <tr>
                                            <td class="fw-medium">
                                                <a href="{{url('project/'.$item->id)}}" class="text-reset">
                                                    {{$item->name}}
                                                </a>
                                            </td>
                                            <td>
                                                {!! \App\Helper\Helper::avatar($item->user->avatar, $item->user->name) !!}
                                                <a href="javascript: void(0);" class="text-reset">
                                                    {{$item->user->name}}
                                                </a>
                                            </td>
{{--                                            <td>--}}
{{--                                                <div class="d-flex align-items-center">--}}
{{--                                                    <div class="flex-shrink-0 me-1 text-muted fs-13">53%</div>--}}
{{--                                                    <div class="progress progress-sm  flex-grow-1"--}}
{{--                                                         style="width: 68%;">--}}
{{--                                                        <div class="progress-bar bg-primary rounded"--}}
{{--                                                             role="progressbar" style="width: 53%"--}}
{{--                                                             aria-valuenow="53" aria-valuemin="0"--}}
{{--                                                             aria-valuemax="100"></div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
                                            <td>
                                                <div class="avatar-group flex-nowrap">
                                                    @foreach($item->assignUsers as $assignUser)
                                                        <div class="avatar-group-item">
                                                            <a href="javascript: void(0);" class="d-inline-block">
                                                               {!! \App\Helper\Helper::avatar($assignUser->avatar, $assignUser->name) !!}
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-soft-{{config('constants.status_color')[$item->status]}}">
                                                {{config('constants.project_status')[$item->status]}}
                                                </span>
                                            </td>
                                            <td class="text-muted">
                                                {{$item->end_date}}
                                            </td>
                                        </tr><!-- end tr -->
                                    @endforeach
                                    </tbody><!-- end tbody -->
                                </table><!-- end table -->
                            </div>

                            <div class="align-items-center mt-xl-3 mt-4 justify-content-between d-flex">
                                <div class="flex-shrink-0">
                                    <div class="text-muted">Showing <span class="fw-semibold">{{$projects->count()}}</span> of <span
                                            class="fw-semibold"> {{$projects->total()}}</span> Results
                                    </div>
                                </div>
                                {!! $projects->appends(['filter' => $filter, 'sort' => $sort, 'direction' => $direction])->links('vendor.pagination.custom')->render() !!}
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
            <form action="{{url('create_project')}}" method="post" class="needs-validation" enctype="multipart/form-data">
                {{csrf_field()}}
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
                                        @foreach(config('constants.project_status') as $key => $val)
                                            @if($key !== "all")
                                                <option value="{{$key}}">{{$val}}</option>
                                            @endif
                                        @endforeach
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
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>

{{--                                <div>--}}
{{--                                    <ul class="list-unstyled vstack gap-2 mb-0">--}}
{{--                                        @foreach($users as $user)--}}
{{--                                            <li>--}}
{{--                                                <div class="form-check d-flex align-items-center">--}}
{{--                                                    <input class="form-check-input me-3" type="checkbox" name="assignedTo[]"--}}
{{--                                                           value="{{$user->id}}" id="{{$user->id}}">--}}
{{--                                                    <label class="form-check-label d-flex align-items-center" for="anna-adame">--}}
{{--                                                    <span class="flex-shrink-0">--}}
{{--                                                        <img src="{{asset('public/images/'.$user->avatar)}}"--}}
{{--                                                             alt="" class="avatar-xxs rounded-circle">--}}
{{--                                                    </span>--}}
{{--                                                        <span class="flex-grow-1 ms-2">--}}
{{--                                                        {{$user->name}}--}}
{{--                                                    </span>--}}
{{--                                                    </label>--}}
{{--                                                </div>--}}
{{--                                            </li>--}}
{{--                                        @endforeach--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
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

@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/quill/quill.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/multi.js/multi.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/@tarekraafat/@tarekraafat.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/dashboard-projects.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

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
@endsection
