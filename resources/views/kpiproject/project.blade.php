@extends('layouts.master')
@section('title') @lang('translation.projects') @endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/quill/quill.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/multi.js/multi.js.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/@tarekraafat/@tarekraafat.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="modal fade zoomIn" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-soft-info">
                    <h5 class="modal-title" id="createTaskModelLabel">Create Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="close-modal"></button>
                </div>
                <form action="{{url('create_task')}}" method="post">
                    {{csrf_field()}}
                    <input type="hidden" value="{{$project->id}}" name="project_id">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-9 col-xl-9 col-md-9 col-sm-12">
                                <div class="col-lg-12">
                                    <label for="task_name" class="form-label">Task Name</label>
                                    <input type="text" id="task_name" class="form-control" name="name" placeholder="Project name"
                                           required />
                                </div>
                                <!--end col-->
                                <div class="col-lg-12">
                                    <div class="mt-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea rows="5" type="text" id="description" name="note" class="form-control ckeditor-classic" placeholder="Description"></textarea>
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
                                        <label for="ticket-status" class="form-label">Status</label>
                                        <select class="form-control" data-choices data-choices-search-false name="status" id="ticket-status">
                                            <option value="">Status</option>
                                            @foreach(config('constants.task_status') as $key => $val)
                                                @if($key !== "all")
                                                    <option value="{{$key}}">{{$val}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <!--end col-->
                                </div>
                            </div>
                            <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12">
                                <div class="col-lg-12">
                                    <label class="form-label">Assigned To</label>
                                    <div data-simplebar style="max-height: 350px;">
                                        <ul class="list-unstyled vstack gap-2 mb-0">
                                            @foreach($project->assignUsers as $user)
                                                <li>
                                                    <div class="form-check d-flex align-items-center">
                                                        <input class="form-check-input me-3" type="checkbox" name="assignedTo[]"
                                                               value="{{$user->id}}" id="{{$user->id}}">
                                                        <label class="form-check-label d-flex align-items-center" for="anna-adame">
                                                            <span class="flex-shrink-0">
                                                                {!! \App\Helper\Helper::avatar($user->avatar, $user->name) !!}
                                                            </span>
                                                            <span class="flex-grow-1 ms-2">{{$user->name}}</span>
                                                        </label>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" id="close-modal"
                                    data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="add-btn">Add Task</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mt-n4 mx-n4">
                <div class="bg-soft-warning">
                    <div class="card-body pb-0 px-4">
                        <div class="row mb-3">
                            <div class="col-md">
                                <div class="row align-items-center g-3">
                                    <div class="col-md">
                                        <div>
                                            <h4 class="fw-bold">{{$project->name}}</h4>
                                            <div class="hstack gap-3 flex-wrap">
                                                {{--                                                <div><i class="ri-building-line align-bottom me-1"></i> Themesbrand</div>--}}
                                                {{--                                                <div class="vr"></div>--}}
                                                <div>Start Date : <span
                                                        class="fw-medium">{{$project->start_date}}</span></div>
                                                <div class="vr"></div>
                                                <div>End Date : <span class="fw-medium">{{$project->end_date}}</span>
                                                </div>
                                                <div class="vr"></div>
                                                <div
                                                    class="badge rounded-pill bg-{{config('constants.status_color')[$project->status]}} fs-12">{{config('constants.project_status')[$project->status]}}</div>
                                                {{--                                                <div class="badge rounded-pill bg-danger fs-12">High</div>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
    </div>

    @include('layouts.errors')
    @include('layouts.flash-message')


    <div class="row">
        <div class="col-xl-9 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="text-muted">
                        <h6 class="mb-3 fw-semibold text-uppercase">Summary</h6>
                        <div class="ql-editor">{!! $project->description !!}</div>

                        <div class="pt-3 border-top border-top-dashed mt-4">
                            <div class="row">

                                <div class="col-lg-3 col-sm-6">
                                    <div>
                                        <p class="mb-2 text-uppercase fw-medium">Start Date :</p>
                                        <h5 class="fs-15 mb-0">{{$project->start_date}}</h5>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div>
                                        <p class="mb-2 text-uppercase fw-medium">End Date :</p>
                                        <h5 class="fs-15 mb-0">{{$project->end_date}}</h5>
                                    </div>
                                </div>
                                {{--                                                    <div class="col-lg-3 col-sm-6">--}}
                                {{--                                                        <div>--}}
                                {{--                                                            <p class="mb-2 text-uppercase fw-medium">Priority :</p>--}}
                                {{--                                                            <div class="badge bg-danger fs-12">High</div>--}}
                                {{--                                                        </div>--}}
                                {{--                                                    </div>--}}
                                <div class="col-lg-3 col-sm-6">
                                    <div>
                                        <p class="mb-2 text-uppercase fw-medium">Status :</p>
                                        <div class="badge bg-{{config('constants.status_color')[$project->status]}} fs-12">{{config('constants.project_status')[$project->status]}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            @if(auth()->user()->id == $project->leader_id)
                <div class="d-flex mb-3 justify-content-end">
                    <a data-bs-toggle="modal" data-bs-target="#createProjectModal" class="btn btn-outline-primary btn-sm me-1">Edit Project</a>
                    <a class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">Delete Project</a>
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4 class="card-title flex-grow-1 mb-0">Tasks</h4>
                    @if(auth()->user()->id == $project->leader_id)
                        <a class="btn btn-success btn-sm add-btn" data-bs-toggle="modal" data-bs-target="#createTaskModal"><i
                                class="ri-add-line align-bottom me-1"></i> Create New Task</a>
                    @endif
                </div><!-- end cardheader -->
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-nowrap table-centered align-middle">
                            <thead class="bg-light text-muted">
                            <tr>
                                <th scope="col">Task</th>
                                <th scope="col">Assigned To</th>
                                <th scope="col">Due Date</th>
                                <th scope="col">Status</th>

                            </tr><!-- end tr -->
                            </thead><!-- thead -->

                            <tbody>
                            @foreach($tasks as $item)
                                <tr>
                                    <td class="fw-medium">
{{--                                        <a href="{{url('task/'.$item->id)}}" class="text-reset">--}}
{{--                                            {{$item->name}}--}}
{{--                                        </a>--}}
                                        <a href="#" class="text-reset">
                                            {{$item->name}}
                                        </a>
                                    </td>

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
                                        {{$item->end_date}}
                                    </td>

                                    <td class="text-muted">
                                        <span class="badge badge-soft-{{config('constants.status_color')[$item->status]}}">
                                            {{config('constants.task_status')[$item->status]}}
                                        </span>
                                    </td>
                                </tr><!-- end tr -->
                            @endforeach
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->
                    </div>

                    <div class="align-items-center mt-xl-3 mt-4 justify-content-between d-flex">
                        <div class="flex-shrink-0">
                            <div class="text-muted">Showing <span class="fw-semibold">{{$tasks->count()}}</span> of <span
                                    class="fw-semibold"> {{$tasks->total()}}</span> Results
                            </div>
                        </div>
                        {{$tasks->links('vendor.pagination.custom')}}
                    </div>

                </div><!-- end card body -->
            </div><!-- end card -->
        </div>


        <!-- ene col -->
        <div class="col-xl-3 col-lg-4">
            <div class="card">
                <div class="card-header align-items-center d-flex border-bottom-dashed">
                    <h4 class="card-title mb-0 flex-grow-1">Members</h4>
                </div>

                <div class="card-body">
                    <div data-simplebar style="height: 235px;" class="mx-n3 px-3">
                        <div class="vstack gap-3">
                            @foreach($project->assignUsers as $user)
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="fs-13 mb-0">
                                            {!! \App\Helper\Helper::avatar($user->avatar, $user->name) !!}
                                            <a href="#" class="text-body">
                                                {{$user->name}}
                                            </a>
                                        </h5>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- end list -->
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
            @if($project->attach_path)
            <div class="card">
                <div class="card-header align-items-center d-flex border-bottom-dashed">
                    <h4 class="card-title mb-0 flex-grow-1">Attachment</h4>
                </div>


                <div class="card-body">
                    <div class="vstack gap-2">
                        <div class="border rounded border-dashed p-2">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-sm">
                                            <div
                                                class="avatar-title bg-light text-secondary rounded fs-24">
                                                <i class="ri-folder-zip-line"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="fs-13 mb-1"><a href="#"
                                                                  class="text-body text-truncate d-block">{{$project->attach_origin_name}}</a>
                                        </h5>
                                        {{--                                    <div>2.2MB</div>--}}
                                    </div>
                                    <div class="flex-shrink-0 ms-2">
                                        <div class="d-flex gap-1">
                                            <a href="{{asset('public/attaches/'.$project->attach_path)}}"
                                               class="btn btn-icon text-muted btn-sm fs-18"><i
                                                    class="ri-download-2-line"></i></a>
                                        </div>
                                    </div>
                                </div>
                        </div>

{{--                        <div class="border rounded border-dashed p-2">--}}
{{--                            <div class="d-flex align-items-center">--}}
{{--                                <div class="flex-shrink-0 me-3">--}}
{{--                                    <div class="avatar-sm">--}}
{{--                                        <div--}}
{{--                                            class="avatar-title bg-light text-secondary rounded fs-24">--}}
{{--                                            <i class="ri-file-ppt-2-line"></i>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="flex-grow-1 overflow-hidden">--}}
{{--                                    <h5 class="fs-13 mb-1"><a href="#"--}}
{{--                                                              class="text-body text-truncate d-block">MCHD Manager-admin.ppt</a>--}}
{{--                                    </h5>--}}
{{--                                    <div>2.4MB</div>--}}
{{--                                </div>--}}
{{--                                <div class="flex-shrink-0 ms-2">--}}
{{--                                    <div class="d-flex gap-1">--}}
{{--                                        <button type="button"--}}
{{--                                                class="btn btn-icon text-muted btn-sm fs-18"><i--}}
{{--                                                class="ri-download-2-line"></i></button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="border rounded border-dashed p-2">--}}
{{--                            <div class="d-flex align-items-center">--}}
{{--                                <div class="flex-shrink-0 me-3">--}}
{{--                                    <div class="avatar-sm">--}}
{{--                                        <div--}}
{{--                                            class="avatar-title bg-light text-secondary rounded fs-24">--}}
{{--                                            <i class="ri-folder-zip-line"></i>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="flex-grow-1 overflow-hidden">--}}
{{--                                    <h5 class="fs-13 mb-1"><a href="#"--}}
{{--                                                              class="text-body text-truncate d-block">Images.zip</a>--}}
{{--                                    </h5>--}}
{{--                                    <div>1.2MB</div>--}}
{{--                                </div>--}}
{{--                                <div class="flex-shrink-0 ms-2">--}}
{{--                                    <div class="d-flex gap-1">--}}
{{--                                        <button type="button"--}}
{{--                                                class="btn btn-icon text-muted btn-sm fs-18"><i--}}
{{--                                                class="ri-download-2-line"></i></button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="border rounded border-dashed p-2">--}}
{{--                            <div class="d-flex align-items-center">--}}
{{--                                <div class="flex-shrink-0 me-3">--}}
{{--                                    <div class="avatar-sm">--}}
{{--                                        <div--}}
{{--                                            class="avatar-title bg-light text-secondary rounded fs-24">--}}
{{--                                            <i class="ri-image-2-line"></i>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="flex-grow-1 overflow-hidden">--}}
{{--                                    <h5 class="fs-13 mb-1"><a href="#"--}}
{{--                                                              class="text-body text-truncate d-block">bg-pattern.png</a>--}}
{{--                                    </h5>--}}
{{--                                    <div>1.1MB</div>--}}
{{--                                </div>--}}
{{--                                <div class="flex-shrink-0 ms-2">--}}
{{--                                    <div class="d-flex gap-1">--}}
{{--                                        <button type="button"--}}
{{--                                                class="btn btn-icon text-muted btn-sm fs-18"><i--}}
{{--                                                class="ri-download-2-line"></i></button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
            @endif
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->


    <div class="modal fade zoomIn" id="createProjectModal" tabindex="-1" aria-labelledby="createProjectModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-soft-info">
                    <h5 class="modal-title" id="createProjectModelLabel">Edit Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="close-modal"></button>
                </div>
                <form action="{{url('update_project')}}" method="post" enctype="multipart/form-data" class="needs-validation">
                    {{csrf_field()}}
                    <input name="project_id" type="hidden" value="{{$project->id}}">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-8 col-md-8 col-sm-12">
                                <div class="col-lg-12">
                                    <label for="project_name" class="form-label">Project Name</label>
                                    <input type="text" id="project_name" class="form-control" name="name" value="{{$project->name}}" placeholder="Project name"
                                           required />
                                </div>
                                <!--end col-->
                                <div class="col-lg-12">
                                    <div class="mt-3">
                                        <label for="project_definition_aims" class="form-label">Definition and aims</label>
                                        <input type="hidden" value="" name="definition_aims">
                                        <div style="height: 300px" id="project_definition_aims" class="project-snow-editor">{!! $project->definition_aims !!}</div>
                                    </div>

                                </div>
                                <!--end col-->


                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 mt-3">
                                        <label for="project_start_date" class="form-label">Start Date</label>
                                        <input type="text" id="project_start_date" class="form-control" name="start_date" data-provider="flatpickr"
                                               placeholder="Due date" required value="{{$project->start_date}}"/>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 mt-3">
                                        <label for="project_end_date" class="form-label">End Date</label>
                                        <input type="text" id="project_end_date" class="form-control" name="end_date" data-provider="flatpickr"
                                               placeholder="Due date" required value="{{$project->end_date}}" />
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6 col-md-6 col-sm-6 mt-3">
                                        <label for="project_status" class="form-label">Status</label>
                                        <select class="form-control" data-choices data-choices-search-false name="status" id="project_status">
                                            <option value="">Status</option>
                                            @foreach(config('constants.project_status') as $key => $val)
                                                @if($key !== "all")
                                                    <option {{$key===$project->status? "selected" : ""}} value="{{$key}}">{{$val}}</option>
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
                                        name="project_assignedTo[]"
                                        id="multiselect-header">
                                        @foreach($users as $user)
                                            @php($flag = false)
                                            @foreach($project->assignUsers as $selectedUser)
                                                <?php
                                                    if ($user->id === $selectedUser->id){
                                                        $flag = true;
                                                        break;
                                                    }
                                                ?>
                                            @endforeach
                                            <option {{$flag? "selected" : ""}} value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
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
                            <button type="button" class="btn btn-success" id="update-btn">Edit Project</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100000000">
        <div id="myToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">

                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>


    <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json"
                               trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:120px;height:120px">
                    </lord-icon>
                    <div class="mt-0">
                       <div class="fs-15 mx-5">
                           <h4 class="mb-3">Are you sure ?</h4>
                           <p class="text-muted mx-4 mb-0">Are you Sure You want to Delete this Project ?</p>
                       </div>
                    </div>
                    <div class="hstack gap-2 justify-content-center mt-3">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                        <form method="post" action="{{url('delete_project')}}">
                            {{csrf_field()}}
                            <input type="hidden" name="project_id" value="{{$project->id}}">
                            <button type="submit" href="javascript:void(0);" class="btn btn-danger">Yes, Delete It!</button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->




    @endsection
    @section('script')
        <!-- apexcharts -->
        <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/multi.js/multi.js.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/@tarekraafat/@tarekraafat.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/quill/quill.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-editor.init.js') }}"></script>

        <script src="{{ URL::asset('/assets/js/pages/dashboard-projects.init.js') }}"></script>
        <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

        <script>
            function NotifyToUser(msg){
                var element = document.getElementById("myToast");
                var myToast = new bootstrap.Toast(element);
                document.querySelector(".toast-body").innerHTML = msg;
                myToast.show();
            }

            (function () {
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
                var snowEditor = document.querySelectorAll(".project-snow-editor");

                if (snowEditor) {
                    snowEditor.forEach(function (item) {
                        var snowEditorData = {};
                        var issnowEditorVal = item.classList.contains("project-snow-editor");

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
                var start_date = document.querySelector("#project_start_date");
                var end_date = document.querySelector("#project_end_date");
                var project_status = document.querySelector("#project_status");
                var assignedTo = document.querySelector('select[name="project_assignedTo[]"]');
                var definition_aims = document.querySelector("input[name='definition_aims']");

                // submit
                document.querySelector("#update-btn").addEventListener("click", function () {
                    definition_aims.value = myEditor.container.firstChild.innerHTML;
                    if (project_name.value == ""){
                        NotifyToUser("Please input project name.");
                        return;
                    }
                    if(definition_aims.value == "<p><br></p>"){;
                        NotifyToUser("Please input definition and aims of the project.");
                        return;
                    }
                    if(start_date.value == ""){
                        NotifyToUser("Please select start date.");
                        return;
                    }
                    if(start_date.value != "" && end_date.value != ""){
                        if(parseInt(start_date.value.replace(/-/g,""),10) > parseInt(end_date.value.replace(/-/g,""),10)){
                            NotifyToUser("The end date has to be later regarding to start date");
                            return;
                        }
                    }

                    if (project_status.value == ""){
                        NotifyToUser("Please select status of the project.");
                        return;
                    }

                    if (assignedTo.value == ""){
                        NotifyToUser("Please select assignee.");
                        return;
                    }
                    form.submit();
                });

            })();
        </script>
@endsection
