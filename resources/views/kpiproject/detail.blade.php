@extends('layouts.master')
@section('title')
    @lang('translation.kpi_project_detail')
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card ribbon-box ribbon-fill right mt-n4 mx-n4">
                 <span class="ribbon-three ribbon-three-danger">
                                        <span>KPI Project</span>
                                    </span>
                <div class="bg-soft-secondary">
                    <div class="card-body pb-0 px-4">
                        <div class="row mb-3">
                            <div class="col-md">
                                <div class="row align-items-center g-3">
                                    <div class="col-md-auto">
                                        {!! \App\Helper\Helper::avatar($project->user->avatar, $project->user->name, 'avatar-md', 30, auth() && auth()->user()->id === $project->user->id) !!}
                                    </div>
                                    <div class="col-md">
                                        <div>
                                            <h4 class="fw-bold">{{$project->name}}</h4>
                                            <div class="hstack gap-3 flex-wrap">
                                                <div>Department : <span class="fw-medium">{{$project->department->name}}</span></div>
                                                <div class="vr"></div>
                                                <div>Leader : <span class="fw-medium">{{$project->user->name}}</span></div>
                                                <div class="vr"></div>
                                                <div>Create Date : <span class="fw-medium">{{\App\Helper\Helper::letter_date($project->created_at)}}</span></div>
                                                <div class="vr"></div>
                                                <div>Start Date : <span class="fw-medium">{{\App\Helper\Helper::letter_date($project->start_date)}}</span></div>
                                                <div class="vr"></div>
                                                <div>Due Date : <span class="fw-medium">{{\App\Helper\Helper::letter_date($project->end_date)}}</span></div>
                                                <div class="vr"></div>
                                                @if(\App\Helper\Helper::isNew($project->created_at))
                                                    <div class="badge rounded-pill bg-info fs-12">New</div>
                                                @endif
{{--                                                <div class="badge rounded-pill bg-danger fs-12">High</div>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active fw-semibold" data-bs-toggle="tab" href="#project-overview"
                                   role="tab">
                                    Overview
                                </a>
                            </li>

{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#project-activities" role="tab">--}}
{{--                                    Activities--}}
{{--                                </a>--}}
{{--                            </li>--}}
                        </ul>
                    </div>
                    <!-- end card body -->
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
    @include('layouts.errors')
    @include('layouts.flash-message')
    <div class="row">
        <div class="col-lg-12">
            <div class="tab-content text-muted">
                <div class="tab-pane fade show active" id="project-overview" role="tabpanel">
                    <div class="row">
                        <div class="col-xl-9 col-lg-8">
                            <div class="card border">
                                <div class="card-body">
                                    <div class="text-muted">
                                        <h6 class="mb-3 fw-semibold text-uppercase">Description</h6>
                                        <div class="ql-editor">
                                            {!! $project->description !!}
                                        </div>


                                        <div class="pt-3 border-top border-top-dashed mt-4">
                                            <div class="row">

                                                <div class="col-lg-3 col-sm-6">
                                                    <div>
                                                        <p class="mb-2 text-uppercase fw-medium">Start Date :</p>
                                                        <h5 class="fs-15 mb-0">{{\App\Helper\Helper::letter_date($project->start_date)}}</h5>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div>
                                                        <p class="mb-2 text-uppercase fw-medium">Due Date :</p>
                                                        <h5 class="fs-15 mb-0">{{\App\Helper\Helper::letter_date($project->end_date)}}</h5>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-sm-6 mb-3">
                                                    <div>
                                                        <p class="mb-2 text-uppercase fw-medium">Status :</p>
                                                        <div class="badge bg-{{\App\Helper\Helper::getStatusColor($project->status)}} fs-12">{{\App\Helper\Helper::getStatus(0, $project->status)}}</div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-sm-6">
                                                    @if(\App\Helper\Helper::statusChangeable(auth()->user(), $project))
                                                        <p class="mb-2 text-uppercase fw-medium">Change Status :</p>
                                                        <div class="mb-4">
                                                            <form id="form_status" method="post" action="{{url('clinic/change_status')}}">
                                                                @csrf
                                                                <input type="hidden" name="type" value="1">
                                                                <input type="hidden" name="id" value="{{$project->id}}">
                                                                <select id="change_status" class="form-control" name="status" data-choices data-choices-search-false>
                                                                    @foreach(config('constants.big_project_status') as $key => $val)
                                                                        @if($key !== "all")
                                                                            <option {{$project->status == $key? 'selected' : ''}} value="{{$key}}">{{$val}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                            <div class="pt-3 border-top border-top-dashed mt-4 d-flex justify-content-end">
                                                <a href="{{url('kpibigproject/detail/'.$project->big_project->id)}}" class="btn btn-outline-danger w-sm me-1">Back</a>
                                                @if(\App\Helper\Helper::clinicProjectEditable(auth()->user(), $project))
                                                    <a href="{{url('kpiproject/edit/'.$project->id)}}" class="btn btn-outline-success">Edit</a>
                                                @endif
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- ene col -->
                        <div class="col-xl-3 col-lg-4">
                            <div class="card">
                                <div class="card-header align-items-center border-bottom-dashed">
                                    <h4 class="card-title mb-0 text-center">{{$project->department->name}}</h4>
                                </div>
                                <div class="card-header align-items-center d-flex justify-content-between border-bottom-dashed">
                                    <h4 class="card-title mb-0">Leader</h4>
                                    <div class="float-lg-end">
                                        {!! \App\Helper\Helper::avatar($project->user->avatar, $project->user->name, 'avatar-xs', 11, auth() && auth()->user()->id === $project->user->id) !!}
                                    </div>
                                </div>
                                <div class="card-header align-items-center d-flex border-bottom-dashed">
                                    <h4 class="card-title mb-0 flex-grow-1">Members</h4>
                                    @if(\App\Helper\Helper::clinicProjectEditable(auth()->user(), $project))
                                    <div class="flex-shrink-0">
                                        <button data-bs-toggle="modal" data-bs-target="#inviteMembersModal" onclick="open_invite_modal()" type="button" class="btn btn-soft-danger btn-sm"><i
                                                class="ri-share-line me-1 align-bottom"></i> Invite Leader</button>
                                    </div>
                                    @endif
                                </div>

                                <div class="card-body">
                                    <div data-simplebar style="height: 235px;" class="mx-n3 px-3">
                                        <div class="vstack gap-3">
                                            @foreach($project->assignUsers as $item)
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-xs flex-shrink-0 me-3">
                                                        {!! \App\Helper\Helper::avatar($item->avatar, $item->name, 'avatar-xs', 11, auth() && auth()->user()->id === $item->id) !!}
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 class="fs-13 mb-0"><a href="#" class="text-body d-block">{{$item->name}}</a></h5>
                                                    </div>
                                                    @if(\App\Helper\Helper::clinicProjectEditable(auth()->user(), $project))
                                                    <div class="flex-shrink-0">
                                                        <div class="d-flex align-items-center gap-1">
{{--                                                            <button type="button" class="btn btn-light btn-sm">Message</button>--}}
                                                            <div class="dropdown">
                                                                <button class="btn btn-icon btn-sm fs-16 text-muted dropdown"
                                                                        type="button" data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                    <i class="ri-more-fill"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
{{--                                                                    <li><a class="dropdown-item" href="javascript:void(0);"><i--}}
{{--                                                                                class="ri-eye-fill text-muted me-2 align-bottom"></i>View</a>--}}
{{--                                                                    </li>--}}
{{--                                                                    <li>--}}
{{--                                                                        <a class="dropdown-item" href="javascript:void(0);"><i--}}
{{--                                                                                class="ri-star-fill text-muted me-2 align-bottom"></i>Favourite</a>--}}
{{--                                                                    </li>--}}
                                                                    <li><a class="dropdown-item" href="javascript:delete_deader({{$item->id}})"><i
                                                                                class="ri-delete-bin-5-fill text-muted me-2 align-bottom"></i>Delete</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                                <!-- end member item -->
                                            @endforeach
                                        </div>
                                        <!-- end list -->
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->

                            <div class="card">
                                <div class="card-header align-items-center d-flex border-bottom-dashed">
                                    <h4 class="card-title mb-0 flex-grow-1">Attachments</h4>
                                    @if(\App\Helper\Helper::clinicProjectEditable(auth()->user(), $project))
                                    <div class="flex-shrink-0">
                                        <button data-bs-toggle="modal" data-bs-target="#modal_uplaod" onclick="open_modal_uplaod()" type="button" class="btn btn-soft-info btn-sm"><i
                                                class="ri-upload-2-fill me-1 align-bottom"></i> Upload</button>
                                    </div>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div class="vstack gap-2">
                                        @foreach($project->attachments as $item)
                                            <div class="border rounded border-dashed p-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar-sm">
                                                            <div class="avatar-title bg-light text-secondary rounded fs-24">
                                                                <i class="ri-folder-zip-line"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="fs-13 mb-1"><a href="#"
                                                                                  class="text-body text-truncate d-block">{{$item->real_name}}</a></h5>
                                                        <div>2.2MB</div>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-2">
                                                        <div class="d-flex gap-1">
                                                            <a download href="{{url('public/attaches/'.$item->path_name)}}"
                                                                    class="btn btn-icon text-muted btn-sm fs-18"><i
                                                                    class="ri-download-2-line"></i>
                                                            </a>
                                                            @if(\App\Helper\Helper::clinicProjectEditable(auth()->user(), $project))
                                                            <div class="dropdown">
                                                                <button class="btn btn-icon text-muted btn-sm fs-18 dropdown"
                                                                        type="button" data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                    <i class="ri-more-fill"></i>
                                                                </button>

                                                                <ul class="dropdown-menu">
{{--                                                                    <li><a class="dropdown-item" href="#"><i--}}
{{--                                                                                class="ri-pencil-fill align-bottom me-2 text-muted"></i>--}}
{{--                                                                            Rename</a></li>--}}
                                                                    <li><a class="dropdown-item" href="javascript:delete_attachment({{$item->id}})"><i
                                                                                class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                            Delete</a></li>
                                                                </ul>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>

                <!-- end tab pane -->
                <div class="tab-pane fade" id="project-activities" role="tabpanel">
{{--                    <div class="card">--}}
{{--                        <div class="card-body">--}}
{{--                            <h5 class="card-title">Activities</h5>--}}
{{--                            <div class="acitivity-timeline py-3">--}}
{{--                                <div class="acitivity-item d-flex">--}}
{{--                                    <div class="flex-shrink-0">--}}
{{--                                        <img src="{{ URL::asset('assets/images/users/avatar-1.jpg') }}" alt=""--}}
{{--                                             class="avatar-xs rounded-circle acitivity-avatar" />--}}
{{--                                    </div>--}}
{{--                                    <div class="flex-grow-1 ms-3">--}}
{{--                                        <h6 class="mb-1">Oliver Phillips <span--}}
{{--                                                class="badge bg-soft-primary text-primary align-middle">New</span></h6>--}}
{{--                                        <p class="text-muted mb-2">We talked about a project on linkedin.</p>--}}
{{--                                        <small class="mb-0 text-muted">Today</small>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="acitivity-item py-3 d-flex">--}}
{{--                                    <div class="flex-shrink-0 avatar-xs acitivity-avatar">--}}
{{--                                        <div class="avatar-title bg-soft-success text-success rounded-circle">--}}
{{--                                            N--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="flex-grow-1 ms-3">--}}
{{--                                        <h6 class="mb-1">Nancy Martino <span--}}
{{--                                                class="badge bg-soft-secondary text-secondary align-middle">In--}}
{{--                                                Progress</span></h6>--}}
{{--                                        <p class="text-muted mb-2"><i class="ri-file-text-line align-middle ms-2"></i>--}}
{{--                                            Create new project Buildng product</p>--}}
{{--                                        <div class="avatar-group mb-2">--}}
{{--                                            <a href="javascript: void(0);" class="avatar-group-item"--}}
{{--                                               data-bs-toggle="tooltip" data-bs-placement="top" title=""--}}
{{--                                               data-bs-original-title="Christi">--}}
{{--                                                <img src="{{ URL::asset('assets/images/users/avatar-4.jpg') }}" alt=""--}}
{{--                                                     class="rounded-circle avatar-xs" />--}}
{{--                                            </a>--}}
{{--                                            <a href="javascript: void(0);" class="avatar-group-item"--}}
{{--                                               data-bs-toggle="tooltip" data-bs-placement="top" title=""--}}
{{--                                               data-bs-original-title="Frank Hook">--}}
{{--                                                <img src="{{ URL::asset('assets/images/users/avatar-3.jpg') }}" alt=""--}}
{{--                                                     class="rounded-circle avatar-xs" />--}}
{{--                                            </a>--}}
{{--                                            <a href="javascript: void(0);" class="avatar-group-item"--}}
{{--                                               data-bs-toggle="tooltip" data-bs-placement="top" title=""--}}
{{--                                               data-bs-original-title=" Ruby">--}}
{{--                                                <div class="avatar-xs">--}}
{{--                                                    <div class="avatar-title rounded-circle bg-light text-primary">--}}
{{--                                                        R--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </a>--}}
{{--                                            <a href="javascript: void(0);" class="avatar-group-item"--}}
{{--                                               data-bs-toggle="tooltip" data-bs-placement="top" title=""--}}
{{--                                               data-bs-original-title="more">--}}
{{--                                                <div class="avatar-xs">--}}
{{--                                                    <div class="avatar-title rounded-circle">--}}
{{--                                                        2+--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
{{--                                        <small class="mb-0 text-muted">Yesterday</small>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="acitivity-item py-3 d-flex">--}}
{{--                                    <div class="flex-shrink-0">--}}
{{--                                        <img src="{{ URL::asset('assets/images/users/avatar-2.jpg') }}" alt=""--}}
{{--                                             class="avatar-xs rounded-circle acitivity-avatar" />--}}
{{--                                    </div>--}}
{{--                                    <div class="flex-grow-1 ms-3">--}}
{{--                                        <h6 class="mb-1">Natasha Carey <span--}}
{{--                                                class="badge bg-soft-success text-success align-middle">Completed</span>--}}
{{--                                        </h6>--}}
{{--                                        <p class="text-muted mb-2">Adding a new event with attachments</p>--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col-xxl-4">--}}
{{--                                                <div class="row border border-dashed gx-2 p-2 mb-2">--}}
{{--                                                    <div class="col-4">--}}
{{--                                                        <img src="{{ URL::asset('assets/images/small/img-2.jpg') }}" alt=""--}}
{{--                                                             class="img-fluid rounded" />--}}
{{--                                                    </div>--}}
{{--                                                    <!--end col-->--}}
{{--                                                    <div class="col-4">--}}
{{--                                                        <img src="{{ URL::asset('assets/images/small/img-3.jpg') }}" alt=""--}}
{{--                                                             class="img-fluid rounded" />--}}
{{--                                                    </div>--}}
{{--                                                    <!--end col-->--}}
{{--                                                    <div class="col-4">--}}
{{--                                                        <img src="{{ URL::asset('assets/images/small/img-4.jpg') }}" alt=""--}}
{{--                                                             class="img-fluid rounded" />--}}
{{--                                                    </div>--}}
{{--                                                    <!--end col-->--}}
{{--                                                </div>--}}
{{--                                                <!--end row-->--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <small class="mb-0 text-muted">25 Nov</small>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="acitivity-item py-3 d-flex">--}}
{{--                                    <div class="flex-shrink-0">--}}
{{--                                        <img src="{{ URL::asset('assets/images/users/avatar-6.jpg') }}" alt=""--}}
{{--                                             class="avatar-xs rounded-circle acitivity-avatar" />--}}
{{--                                    </div>--}}
{{--                                    <div class="flex-grow-1 ms-3">--}}
{{--                                        <h6 class="mb-1">Bethany Johnson</h6>--}}
{{--                                        <p class="text-muted mb-2">added a new member to velzon dashboard</p>--}}
{{--                                        <small class="mb-0 text-muted">19 Nov</small>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="acitivity-item py-3 d-flex">--}}
{{--                                    <div class="flex-shrink-0">--}}
{{--                                        <div class="avatar-xs acitivity-avatar">--}}
{{--                                            <div class="avatar-title rounded-circle bg-soft-danger text-danger">--}}
{{--                                                <i class="ri-shopping-bag-line"></i>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="flex-grow-1 ms-3">--}}
{{--                                        <h6 class="mb-1">Your order is placed <span--}}
{{--                                                class="badge bg-soft-danger text-danger align-middle ms-1">Out of--}}
{{--                                                Delivery</span></h6>--}}
{{--                                        <p class="text-muted mb-2">These customers can rest assured their order has been--}}
{{--                                            placed.</p>--}}
{{--                                        <small class="mb-0 text-muted">16 Nov</small>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="acitivity-item py-3 d-flex">--}}
{{--                                    <div class="flex-shrink-0">--}}
{{--                                        <img src="{{ URL::asset('assets/images/users/avatar-7.jpg') }}" alt=""--}}
{{--                                             class="avatar-xs rounded-circle acitivity-avatar" />--}}
{{--                                    </div>--}}
{{--                                    <div class="flex-grow-1 ms-3">--}}
{{--                                        <h6 class="mb-1">Lewis Pratt</h6>--}}
{{--                                        <p class="text-muted mb-2">They all have something to say beyond the words on the--}}
{{--                                            page. They can come across as casual or neutral, exotic or graphic. </p>--}}
{{--                                        <small class="mb-0 text-muted">22 Oct</small>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="acitivity-item py-3 d-flex">--}}
{{--                                    <div class="flex-shrink-0">--}}
{{--                                        <div class="avatar-xs acitivity-avatar">--}}
{{--                                            <div class="avatar-title rounded-circle bg-soft-info text-info">--}}
{{--                                                <i class="ri-line-chart-line"></i>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="flex-grow-1 ms-3">--}}
{{--                                        <h6 class="mb-1">Monthly sales report</h6>--}}
{{--                                        <p class="text-muted mb-2"><span class="text-danger">2 days left</span>--}}
{{--                                            notification to submit the monthly sales report. <a href="javascript:void(0);"--}}
{{--                                                                                                class="link-warning text-decoration-underline">Reports Builder</a></p>--}}
{{--                                        <small class="mb-0 text-muted">15 Oct</small>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="acitivity-item d-flex">--}}
{{--                                    <div class="flex-shrink-0">--}}
{{--                                        <img src="{{ URL::asset('assets/images/users/avatar-8.jpg') }}" alt=""--}}
{{--                                             class="avatar-xs rounded-circle acitivity-avatar" />--}}
{{--                                    </div>--}}
{{--                                    <div class="flex-grow-1 ms-3">--}}
{{--                                        <h6 class="mb-1">New ticket received <span--}}
{{--                                                class="badge bg-soft-success text-success align-middle">Completed</span>--}}
{{--                                        </h6>--}}
{{--                                        <p class="text-muted mb-2">User <span class="text-secondary">Erica245</span>--}}
{{--                                            submitted a ticket.</p>--}}
{{--                                        <small class="mb-0 text-muted">26 Aug</small>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <!--end card-body-->--}}
{{--                    </div>--}}
                    <!--end card-->
                </div>
                <!-- end tab pane -->
            </div>
        </div>
        <!-- end col -->


        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-soft-primary">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="flex-grow-1">
                            <div class="hstack text-nowrap gap-2">
                                Tasks <span class="badge badge-danger badge-soft-secondary">{{count($project->tasks)}}</span>
                            </div>
                        </div>

                        @if(\App\Helper\Helper::clinicTaskCreatable(auth()->user(), $project))
                        <div class="flex-shrink-0">
                            <a href="{{url('task/create/'.$project->id)}}" class="btn btn-info add-btn">
                                <i class="ri-add-fill me-1 align-bottom"></i> Create Task</a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($project->tasks as $item)
                            <div class="col-xxl-3 col-sm-6 project-card">
                                <div class="card ribbon-box border ribbon-fill shadow-none mb-lg-2 mb-2">
                                    <div class="card-body">
                                        @if(\App\Helper\Helper::isNew($item->created_at))
                                            <div class="ribbon ribbon-danger">New</div>
                                        @endif
                                        <div class="p-3 mt-n3 mx-n3 bg-soft-secondary rounded-top">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <h5 class="mb-0 fs-14 text-center">
                                                        <a href="{{url('task/detail/'.$item->id)}}" class="text-dark">
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
                                                                <a class="dropdown-item" href="{{url('task/detail/'.$item->id)}}"><i
                                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                                    View</a>

                                                                @if(\App\Helper\Helper::clinicTaskEditable(auth()->user(), $item))
                                                                    <a class="dropdown-item" href="{{url('task/edit/'.$item->id)}}"><i
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
                                                        <div class="badge badge-soft-{{\App\Helper\Helper::getStatusColor($item->status)}} fs-12">{{config('constants.project_status')[$item->status]}}</div>
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
                                                <p class="text-muted mb-0 me-2">Leader :</p>
                                                <div class="avatar-group">
                                                    <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                                       data-bs-trigger="hover" data-bs-placement="top" title="{{$item->leader->name}}">
                                                        {!! \App\Helper\Helper::avatar($item->leader->avatar, $item->leader->name, 'avatar-xxs', 11, auth() && auth()->user()->id === $item->leader->id) !!}
                                                    </a>
                                                </div>

                                                <p class="text-muted ms-auto mb-0 me-2">SubTasks : <span class="badge badge-soft-secondary"> {{$item->subTasks->count()}}</span></p>
                                            </div>

                                            <div class="d-flex align-items-center mt-3">
                                                <p class="text-muted mb-0 me-2">Team :</p>
                                                <div class="avatar-group">
                                                    @foreach($item->assignUsers as $member)
                                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                                           data-bs-trigger="hover" data-bs-placement="top" title="{{$member->name}}">
                                                            {!! \App\Helper\Helper::avatar($member->avatar, $member->name, 'avatar-xxs', 11, auth() && auth()->user()->id === $member->id) !!}
                                                        </a>
                                                    @endforeach
                                                </div>
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
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
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
                    <form id="form" method="post" action="{{url('kpiproject/invite/'.$project->id)}}">
                        <input name="id" type="hidden" value="{{$project->id}}">
                        @csrf
                    </form>
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
                            @foreach($members as $item)
                                <div class="d-flex align-items-center member_item">
                                    <div class="avatar-xs flex-shrink-0 me-3">
                                        {!! \App\Helper\Helper::avatar($item->avatar, $item->name, "avatar-xs") !!}
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="fs-13 mb-0"><a href="#" class="text-body d-block name">{{$item->name}}</a>
                                        </h5>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <button type="button" class="btn btn-light btn-sm" onclick="add_user({{json_encode($item)}})">Add</button>
                                    </div>
                                </div>
                            @endforeach
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


    <div id="modal_delete_leader" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json"
                               trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:120px;height:120px">
                    </lord-icon>
                    <div class="mt-0">
                        <div class="fs-15 mx-5">
                            <h4 class="mb-3">Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you Sure You want to Delete this leader ?</p>
                        </div>
                    </div>
                    <div class="hstack gap-2 justify-content-center mt-3">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                        <form method="post" action="{{url('kpiproject/delete_member/'.$project->id)}}">
                            {{csrf_field()}}
                            <input type="hidden" name="member_id" value="">
                            <input type="hidden" name="project_id" value="{{$project->id}}">
                            <button type="submit" href="javascript:void(0);" class="btn btn-danger">Yes, Delete It!</button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



    <div id="modal_delete_attachment" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json"
                               trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:120px;height:120px">
                    </lord-icon>
                    <div class="mt-0">
                        <div class="fs-15 mx-5">
                            <h4 class="mb-3">Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you Sure You want to Delete this file ?</p>
                        </div>
                    </div>
                    <div class="hstack gap-2 justify-content-center mt-3">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                        <form method="post" action="{{url('kpiproject/delete_attachment/'.$project->id)}}">
                            {{csrf_field()}}
                            <input type="hidden" name="attachment_id" value="">
                            <input type="hidden" name="path_name" value="">
                            <input type="hidden" name="project_id" value="{{$project->id}}">
                            <button type="submit" href="javascript:void(0);" class="btn btn-danger">Yes, Delete It!</button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal -->
    <div class="modal fade" id="modal_uplaod" tabindex="-1" aria-labelledby=""
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-3 ps-4 bg-soft-success">
                    <h5 class="modal-title" id="inviteMembersModalLabel">Upload</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form" method="post" action="{{url('kpiproject/upload_file/'.$project->id)}}" enctype="multipart/form-data">
                    <div class="modal-body p-4">
                            <input name="id" type="hidden" value="{{$project->id}}">
                            @csrf
                            <div class="mb-3">
                                <input type="file" class="form-control" name="files[]" multiple>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light w-xs" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success w-xs">Upload</button>
                    </div>
                </form>

            </div>
            <!-- end modal-content -->
        </div>
        <!-- modal-dialog -->
    </div>
    <!-- end modal -->

    <!-- removeProjectModal -->
    <div id="removeProjectModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="form_delete_project" method="post" action="{{url('task/delete_project')}}">
                @csrf
                <input type="hidden" value="" name="task_id">
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
                            <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Task ?</p>
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
    <script src="{{ URL::asset('assets/js/pages/project-overview.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection


@section('script-bottom')
    <script>
        let candidate_user_list = @json($members);
        let user_list = @json($project->assignUsers);
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

            function add_leader_at_top_modal(user){
                $('.members_on_modal').append(avatar(user));
            }

            function delete_leader_at_top_modal(user){
                $('.members_on_modal').empty();
                for (var i = 0; i < user_list.length; i++)
                    $('.members_on_modal').append(avatar(user_list[i]));
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


            function avatar(user, size = 'avatar-xs'){
                let clientNameBothLetters = user.name.split(" ")[0][0];
                if (user.name.split(" ").length > 1)
                    clientNameBothLetters = user.name.split(" ")[0][0]
                        + user.name.split(" ")[user.name.split(" ").length - 1][0];

                let leader = '<a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"\
                            data-bs-trigger="hover" data-bs-placement="top" title="Brent Gonzalez">\
                                <div class="'+ size +'">\
                                    <img src="{{ URL::asset('public/images/') }}/'+ user.avatar +'" alt="" class="rounded-circle img-fluid">\
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

        { // delete leader
            var modal_delete_leader = $('#modal_delete_leader');
            function delete_deader(id) {
                $('input[name="member_id"]').val(id);
                modal_delete_leader.modal("show");
            }
        }

        { // delete attachment
            var modal_delete_attachment = $('#modal_delete_attachment');
            function delete_attachment(id) {
                $('input[name="attachment_id"]').val(id);
                modal_delete_attachment.modal("show");
            }
        }

        { // file upload
            let modal_uplaod = $("#modal_uplaod");
            function open_modal_uplaod(){
                modal_uplaod.modal("show");
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

        {// remove task
            function open_modal_delete_bigproject(id){
                $('input[name="task_id"]').val(id);
                $('#removeProjectModal').modal('show');
            }

            $('#remove-project').click(function () {
                $('#form_delete_project').submit();
            });
        }


        {// change status
            $('#change_status').change(function () {
                $('#form_status').submit();
            });
        }

    </script>
@endsection
