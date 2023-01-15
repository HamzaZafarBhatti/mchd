@extends('layouts.master')
@section('title')
    @lang('translation.kpi_big_project_list')
@endsection
@section('content')
    @component('components.main_breadcrumb')
        @slot('li_1')
            KPI Big Project
        @endslot
        @slot('title')
            KPI Big Project List
        @endslot
    @endcomponent

    @include('layouts.errors')
    @include('layouts.flash-message')
    <div class="row g-4 mb-3">
        <div class="col-sm-auto">
            <div>
                @if(\App\Helper\Helper::clinicBigProjectCreatable(auth()->user(), $code))
                    <a href="{{url('kpibigcreate/'.$code)}}" class="btn btn-success"><i class="ri-add-line align-bottom me-1"></i> Create New</a>
                @endif
            </div>
        </div>
        <div class="col-sm">
            <div class="d-flex justify-content-sm-end gap-2">
                <div class="search-box ms-2">
                    <form method="get">
                        <input type="text" name="filter" value="{{$filter}}" class="form-control" placeholder="Search...">
                        <i class="ri-search-line search-icon"></i>
                    </form>
                </div>

                <form method="get" id="date">
                    <select class="form-control w-md" name="datefilter" data-choices data-choices-search-false>
                        @foreach(config('constants.dates') as $key => $val)
                            <option {{$datefilter==$key? 'selected' : ''}} value="{{$key}}">{{$val}}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </div>


    <div class="row">
        @foreach($big_projects as $item)
            <div class="col-xxl-3 col-sm-6 project-card">
                <div class="card ribbon-box border ribbon-fill shadow-none mb-lg-2 mb-2">
                    <div class="card-body">
                        @if(\App\Helper\Helper::isNew($item->created_at))
                            <div class="ribbon ribbon-info">New</div>
                        @endif
                        <div class="p-3 mt-n3 mx-n3 bg-soft-primary rounded-top">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 fs-14 text-center">
                                        <a href="{{url('kpibigproject/detail/'.$item->id)}}" class="text-dark">
                                            {{ \Illuminate\Support\Str::limit($item->name, 45, $end='...') }}
                                        </a>
                                    </h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="d-flex gap-1 align-items-center my-n2">
                                        <div class="dropdown">
                                            <button class="btn btn-link text-muted p-1 mt-n1 py-0 text-decoration-none fs-15"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <i data-feather="more-horizontal" class="icon-sm"></i>
                                            </button>

                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="{{url('bigproject/detail/'.$item->id)}}"><i
                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                    View</a>
{{--                                                <a class="dropdown-item" href="{{url('bigproject/chart/'.$item->id)}}"><i--}}
{{--                                                        class="ri-bar-chart-fill align-bottom me-2 text-muted"></i>--}}
{{--                                                    Chart</a>--}}
                                                @if(\App\Helper\Helper::clinicBigProjectEditable(auth()->user(), $item))
                                                <a class="dropdown-item" href="{{url('bigproject/edit/'.$item->id)}}"><i
                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                    Edit</a>
                                                <div class="dropdown-divider"></div>
                                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#removeProjectModal" onclick="open_modal_delete_bigproject({{$item->id}})"><i
                                                        class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                    Remove</button>

                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="py-3">
                            <div class="row gy-3">
                                <div class="col-6">
                                    <div>
                                        <p class="text-muted mb-1">Status</p>
                                        <div class="badge badge-soft-{{config('constants.status_color')[$item->status]}} fs-12">{{config('constants.project_status')[$item->status]}}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div>
                                        <p class="text-muted mb-1">Deadline</p>
                                        <h5 class="fs-14">
                                            {{$item->end_date ? date('D j M, Y', strtotime($item->end_date)) : "Continue"}}
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mt-3">
                                <p class="text-muted mb-0 me-2">Manager :</p>
                                <div class="avatar-group">
                                    <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                       data-bs-trigger="hover" data-bs-placement="top" title="{{$item->boss->name}}">
                                        {!! \App\Helper\Helper::avatar($item->boss->avatar, $item->boss->name, 'avatar-xxs', 11, auth() && auth()->user()->id === $item->boss->id) !!}
                                    </a>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mt-3">
                                <p class="text-muted mb-0 me-2">Leaders :</p>
                                <div class="avatar-group">
                                    @foreach($item->assignUsers as $leader)
                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                           data-bs-trigger="hover" data-bs-placement="top" title="{{$leader->name}}">
                                            {!! \App\Helper\Helper::avatar($leader->avatar, $leader->name, 'avatar-xxs', 11, auth() && auth()->user()->id === $leader->id) !!}
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-3">
                                <p class="text-muted mb-0">Projects: <span class="badge badge-soft-secondary"> {{$item->projects->count()}}</span></p>
                                <p class="text-muted mb-0">Tasks : <span class="badge badge-soft-secondary"> {{count($item->tasks($item->projects))}}</span></p>
                                <p class="text-muted mb-0">Sub : <span class="badge badge-soft-secondary"> {{count($item->subTasks($item->projects))}}</span></p>
                            </div>
                        </div>
                        @if(\App\Helper\Helper::progress($item)>=0)
                            <div>
                                <div class="d-flex mb-2">
                                    <div class="flex-grow-1">
                                        <div>Progress</div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div>{{\App\Helper\Helper::progress($item)}}%</div>
                                    </div>
                                </div>

                                <div class="progress progress-sm animated-progress">
                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="{{\App\Helper\Helper::progress($item)}}" aria-valuemin="0"
                                         aria-valuemax="100" style="width: {{\App\Helper\Helper::progress($item)}}%;">
                                    </div><!-- /.progress-bar -->
                                </div><!-- /.progress -->
                            </div>
                        @endif
                            <div class="mt-3 d-flex justify-content-end">
                                <div class="badge badge-soft-dark">{{$item->department->name}}</div>
                            </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        @endforeach
    </div>
    <!-- end row -->


    <div class="row g-0 text-center text-sm-start align-items-center mb-4">
        <div class="col-sm-6">
            <div>
                <p class="mb-sm-0 text-muted">Showing <span class="fw-semibold">{{$big_projects->firstItem()}}</span> to <span
                        class="fw-semibold">{{$big_projects->lastItem()}}</span> of <span class="fw-semibold text-decoration-underline">{{$big_projects->total()}}</span>
                    entries</p>
            </div>
        </div>
        <!-- end col -->
        <div class="col-sm-6">

{{--            {!! $big_projects->appends(['filter' => $filter, 'sort' => $sort, 'direction' => $direction])->links('vendor.pagination.custom')->render() !!}--}}
            {!! $big_projects->appends(['filter' => $filter, 'datefilter' => $datefilter])->links('vendor.pagination.separated')->render() !!}
        </div><!-- end col -->
    </div><!-- end row -->

    <!-- END layout-wrapper -->
    <!-- removeProjectModal -->
    <div id="removeProjectModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="form_delete_bigproject" method="post" action="{{url('bigproject/delete_bigproject')}}">
                @csrf
                <input type="hidden" value="" name="big_project_id">
            </form>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="close-modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                   colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you Sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Big Project ?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn w-sm btn-danger" id="remove-project">Yes, Delete It!</button>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@section('script')
    <script src="{{ URL::asset('assets/js/pages/project-list.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection

@section('script-bottom')
    <script>
        $('select[name="datefilter"]').change(function (){
            $("#date").submit();
        });

        function open_modal_delete_bigproject(id){
            $('input[name="big_project_id"]').val(id);
            $('#removeProjectModal').modal('show');
        }

        $('#remove-project').click(function () {
            $('#form_delete_bigproject').submit();
        });


    </script>
@endsection
