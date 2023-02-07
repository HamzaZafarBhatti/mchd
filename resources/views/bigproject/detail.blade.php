@php
    $pending_cnt = $big_project->projects->where('status', 'pending')->count();
    $inprogress_cnt = $big_project->projects->where('status', 'inprogress')->count();
    $completed_cnt = $big_project->projects->where('status', 'completed')->count();
    $notyetstarted_cnt = $big_project->projects->where('status', 'notyetstarted')->count();
    $overdue_cnt = $big_project->projects->where('status', 'overdue')->count();
    $cancelled_cnt = $big_project->projects->where('status', 'cancelled')->count();
@endphp
@extends('layouts.master')
@section('title')
    @lang('translation.big_project_detail')
@endsection
@section('css_bottom')
    <link href="{{ asset('assets/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card ribbon-box ribbon-fill right mt-n4 mx-n4">
                <div class="bg-soft-primary">
                    <div class="card-body pb-0 px-4">
                        <span class="ribbon-three ribbon-three-info">
                            <span>Big Project</span>
                        </span>
                        <div class="row mb-3">
                            <div class="col-md">
                                <div class="row align-items-center g-3">
                                    <div class="col-md-auto">
                                        {!! \App\Helper\Helper::avatar(
                                            $big_project->boss->avatar,
                                            $big_project->boss->name,
                                            'avatar-md',
                                            30,
                                            auth() && auth()->user()->id === $big_project->boss->id,
                                        ) !!}
                                    </div>
                                    <div class="col-md">
                                        <div>
                                            <h4 class="fw-bold">{{ $big_project->name }}</h4>
                                            <div class="hstack gap-3 flex-wrap">
                                                <div>Department : <span
                                                        class="fw-medium">{{ $big_project->department->name }}</span></div>
                                                <div class="vr"></div>
                                                <div>Manager : <span class="fw-medium">{{ $big_project->boss->name }}</span>
                                                </div>
                                                <div class="vr"></div>
                                                <div>Create Date : <span
                                                        class="fw-medium">{{ \App\Helper\Helper::letter_date($big_project->created_at) }}</span>
                                                </div>
                                                <div class="vr"></div>
                                                <div>Start Date : <span
                                                        class="fw-medium">{{ \App\Helper\Helper::letter_date($big_project->start_date) }}</span>
                                                </div>
                                                <div class="vr"></div>
                                                <div>Due Date : <span
                                                        class="fw-medium">{{ \App\Helper\Helper::letter_date($big_project->end_date) }}</span>
                                                </div>
                                                <div class="vr"></div>
                                                @if (\App\Helper\Helper::isNew($big_project->created_at))
                                                    <div class="badge rounded-pill bg-info fs-12">New</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <ul class="nav nav-tabs-custom border-bottom-0" role="tablist" id="myTab">
                            <li class="nav-item">
                                <a class="nav-link active fw-semibold" data-bs-toggle="tab" href="#project-overview"
                                    role="tab">
                                    Overview
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#project-dashboard"
                                    role="tab">
                                    Charts
                                </a>
                            </li>
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
                                <div class="card-header border-bottom-dashed align-items-center d-flex">
                                    <h6 class="mb-0 fw-semibold text-uppercase flex-grow-1">Description</h6>
                                    @if (\App\Helper\Helper::clinicBigProjectEditable(auth()->user(), $big_project))
                                        <div class="flex-shrink-0">
                                            <button data-bs-toggle="modal" data-bs-target="#edit_modal"
                                                class="btn btn-outline-primary">Edit</button>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div class="text-muted">
                                        <div class="ql-editor">
                                            {!! $big_project->description !!}
                                        </div>

                                        <div class="pt-3 border-top border-top-dashed mt-4">
                                            <div class="row">

                                                <div class="col-lg-3 col-sm-6">
                                                    <div>
                                                        <p class="mb-2 text-uppercase fw-medium">Start Date :</p>
                                                        <h5 class="fs-15 mb-0">
                                                            {{ \App\Helper\Helper::letter_date($big_project->start_date) }}
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div>
                                                        <p class="mb-2 text-uppercase fw-medium">Due Date :</p>
                                                        <h5 class="fs-15 mb-0">
                                                            {{ \App\Helper\Helper::letter_date($big_project->end_date) }}
                                                        </h5>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-sm-6 mb-3">
                                                    <div>
                                                        <p class="mb-2 text-uppercase fw-medium">Status :</p>
                                                        <div
                                                            class="badge bg-{{ \App\Helper\Helper::getStatusColor($big_project->status) }} fs-12">
                                                            {{ \App\Helper\Helper::getStatus(0, $big_project->status) }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-sm-6">
                                                    @if (\App\Helper\Helper::statusChangeable(auth()->user(), $big_project))
                                                        <p class="mb-2 text-uppercase fw-medium">Change Status :</p>
                                                        <div class="mb-4">
                                                            <form id="form_status" method="post"
                                                                action="{{ url('clinic/change_status') }}">
                                                                @csrf
                                                                <input type="hidden" name="type" value="0">
                                                                <input type="hidden" name="id"
                                                                    value="{{ $big_project->id }}">
                                                                <select id="change_status" class="form-control"
                                                                    name="status" data-choices data-choices-search-false>
                                                                    @foreach (config('constants.big_project_status') as $key => $val)
                                                                        @if ($key !== 'all')
                                                                            <option
                                                                                {{ $big_project->status == $key ? 'selected' : '' }}
                                                                                value="{{ $key }}">
                                                                                {{ $val }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                            <div class="pt-3 border-top border-top-dashed mt-4 d-flex justify-content-end">
                                                <a href="{{ url('biglist/' . $big_project->department_code) }}"
                                                    class="btn btn-outline-danger w-sm me-1">Back</a>
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
                                    <h4 class="card-title mb-0 text-center">{{ $big_project->department->name }}</h4>
                                </div>
                                <div
                                    class="card-header align-items-center d-flex justify-content-between border-bottom-dashed">
                                    <h4 class="card-title mb-0">Manager</h4>
                                    @if (\App\Helper\Helper::clinicBigProjectEditable(auth()->user(), $big_project))
                                        <div class="flex-shrink-0">
                                            <button data-bs-toggle="modal" onclick="open_invite_modal_manager()"
                                                type="button" class="btn btn-soft-danger btn-sm"><i
                                                    class="ri-share-line me-1 align-bottom"></i> Invite Manager</button>
                                        </div>
                                    @endif
                                    {{-- <div class="float-lg-end">
                                        {!! \App\Helper\Helper::avatar(
                                            $big_project->boss->avatar,
                                            $big_project->boss->name,
                                            'avatar-xs',
                                            11,
                                            auth() && auth()->user()->id === $big_project->boss->id,
                                        ) !!}
                                    </div> --}}
                                </div>

                                <div class="card-body">
                                    <div data-simplebar style="height: 235px;" class="mx-n3 px-3">
                                        <div class="vstack gap-3">
                                            @foreach ($big_project->assignManagers as $item)
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-xs flex-shrink-0 me-3">
                                                        {!! \App\Helper\Helper::avatar(
                                                            $item->avatar,
                                                            $item->name,
                                                            'avatar-xs',
                                                            11,
                                                            auth() && auth()->user()->id === $item->id,
                                                        ) !!}
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 class="fs-13 mb-0"><a href="#"
                                                                class="text-body d-block">{{ $item->name }}</a></h5>
                                                    </div>
                                                    @if (\App\Helper\Helper::clinicBigProjectEditable(auth()->user(), $big_project))
                                                        <div class="flex-shrink-0">
                                                            <div class="d-flex align-items-center gap-1">
                                                                <div class="dropdown">
                                                                    <button
                                                                        class="btn btn-icon btn-sm fs-16 text-muted dropdown"
                                                                        type="button" data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                        <i class="ri-more-fill"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item"
                                                                                href="javascript:delete_manager({{ $item->id }})"><i
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

                                <div class="card-header align-items-center d-flex border-bottom-dashed">
                                    <h4 class="card-title mb-0 flex-grow-1">Leaders</h4>
                                    @if (\App\Helper\Helper::clinicBigProjectEditable(auth()->user(), $big_project))
                                        <div class="flex-shrink-0">
                                            <button data-bs-toggle="modal" onclick="open_invite_modal()" type="button"
                                                class="btn btn-soft-danger btn-sm"><i
                                                    class="ri-share-line me-1 align-bottom"></i> Invite Leader</button>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-body">
                                    <div data-simplebar style="height: 235px;" class="mx-n3 px-3">
                                        <div class="vstack gap-3">
                                            @foreach ($big_project->assignUsers as $item)
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-xs flex-shrink-0 me-3">
                                                        {!! \App\Helper\Helper::avatar(
                                                            $item->avatar,
                                                            $item->name,
                                                            'avatar-xs',
                                                            11,
                                                            auth() && auth()->user()->id === $item->id,
                                                        ) !!}
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 class="fs-13 mb-0"><a href="#"
                                                                class="text-body d-block">{{ $item->name }}</a></h5>
                                                    </div>
                                                    @if (\App\Helper\Helper::clinicBigProjectEditable(auth()->user(), $big_project))
                                                        <div class="flex-shrink-0">
                                                            <div class="d-flex align-items-center gap-1">
                                                                <div class="dropdown">
                                                                    <button
                                                                        class="btn btn-icon btn-sm fs-16 text-muted dropdown"
                                                                        type="button" data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                        <i class="ri-more-fill"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item"
                                                                                href="javascript:delete_deader({{ $item->id }})"><i
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
                                    @if (\App\Helper\Helper::clinicBigProjectEditable(auth()->user(), $big_project))
                                        <div class="flex-shrink-0">
                                            <a data-bs-toggle="modal" data-bs-target="#modal_uplaod" href="#"
                                                class="btn btn-soft-info btn-sm"><i
                                                    class="ri-upload-2-fill me-1 align-bottom"></i> Upload</a>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div class="vstack gap-2">
                                        @foreach ($big_project->attachments as $item)
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
                                                                class="text-body text-truncate d-block">{{ $item->real_name }}</a>
                                                        </h5>
                                                        <div>2.2MB</div>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-2">
                                                        <div class="d-flex gap-1">
                                                            <a download
                                                                href="{{ url('public/attaches/' . $item->path_name) }}"
                                                                class="btn btn-icon text-muted btn-sm fs-18"><i
                                                                    class="ri-download-2-line"></i>
                                                            </a>
                                                            @if (\App\Helper\Helper::clinicBigProjectEditable(auth()->user(), $big_project))
                                                                <div class="dropdown">
                                                                    <button
                                                                        class="btn btn-icon text-muted btn-sm fs-18 dropdown"
                                                                        type="button" data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                        <i class="ri-more-fill"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        {{--                                                                    <li><a class="dropdown-item" href="#"><i --}}
                                                                        {{--                                                                                class="ri-pencil-fill align-bottom me-2 text-muted"></i> --}}
                                                                        {{--                                                                            Rename</a></li> --}}
                                                                        <li><a class="dropdown-item"
                                                                                href="javascript:delete_attachment({{ $item->id }})"><i
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
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Activities</h5>
                            <div class="acitivity-timeline py-3">
                                <div class="acitivity-item d-flex">
                                    <div class="flex-shrink-0">
                                        <img src="{{ URL::asset('assets/images/users/avatar-1.jpg') }}" alt=""
                                            class="avatar-xs rounded-circle acitivity-avatar" />
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">Oliver Phillips <span
                                                class="badge bg-soft-primary text-primary align-middle">New</span></h6>
                                        <p class="text-muted mb-2">We talked about a project on linkedin.</p>
                                        <small class="mb-0 text-muted">Today</small>
                                    </div>
                                </div>
                                <div class="acitivity-item py-3 d-flex">
                                    <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                        <div class="avatar-title bg-soft-success text-success rounded-circle">
                                            N
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">Nancy Martino <span
                                                class="badge bg-soft-secondary text-secondary align-middle">In
                                                Progress</span></h6>
                                        <p class="text-muted mb-2"><i class="ri-file-text-line align-middle ms-2"></i>
                                            Create new project Buildng product</p>
                                        <div class="avatar-group mb-2">
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                data-bs-original-title="Christi">
                                                <img src="{{ URL::asset('assets/images/users/avatar-4.jpg') }}"
                                                    alt="" class="rounded-circle avatar-xs" />
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                data-bs-original-title="Frank Hook">
                                                <img src="{{ URL::asset('assets/images/users/avatar-3.jpg') }}"
                                                    alt="" class="rounded-circle avatar-xs" />
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                data-bs-original-title=" Ruby">
                                                <div class="avatar-xs">
                                                    <div class="avatar-title rounded-circle bg-light text-primary">
                                                        R
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                data-bs-original-title="more">
                                                <div class="avatar-xs">
                                                    <div class="avatar-title rounded-circle">
                                                        2+
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <small class="mb-0 text-muted">Yesterday</small>
                                    </div>
                                </div>
                                <div class="acitivity-item py-3 d-flex">
                                    <div class="flex-shrink-0">
                                        <img src="{{ URL::asset('assets/images/users/avatar-2.jpg') }}" alt=""
                                            class="avatar-xs rounded-circle acitivity-avatar" />
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">Natasha Carey <span
                                                class="badge bg-soft-success text-success align-middle">Completed</span>
                                        </h6>
                                        <p class="text-muted mb-2">Adding a new event with attachments</p>
                                        <div class="row">
                                            <div class="col-xxl-4">
                                                <div class="row border border-dashed gx-2 p-2 mb-2">
                                                    <div class="col-4">
                                                        <img src="{{ URL::asset('assets/images/small/img-2.jpg') }}"
                                                            alt="" class="img-fluid rounded" />
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-4">
                                                        <img src="{{ URL::asset('assets/images/small/img-3.jpg') }}"
                                                            alt="" class="img-fluid rounded" />
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-4">
                                                        <img src="{{ URL::asset('assets/images/small/img-4.jpg') }}"
                                                            alt="" class="img-fluid rounded" />
                                                    </div>
                                                    <!--end col-->
                                                </div>
                                                <!--end row-->
                                            </div>
                                        </div>
                                        <small class="mb-0 text-muted">25 Nov</small>
                                    </div>
                                </div>
                                <div class="acitivity-item py-3 d-flex">
                                    <div class="flex-shrink-0">
                                        <img src="{{ URL::asset('assets/images/users/avatar-6.jpg') }}" alt=""
                                            class="avatar-xs rounded-circle acitivity-avatar" />
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">Bethany Johnson</h6>
                                        <p class="text-muted mb-2">added a new member to velzon dashboard</p>
                                        <small class="mb-0 text-muted">19 Nov</small>
                                    </div>
                                </div>
                                <div class="acitivity-item py-3 d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-xs acitivity-avatar">
                                            <div class="avatar-title rounded-circle bg-soft-danger text-danger">
                                                <i class="ri-shopping-bag-line"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">Your order is placed <span
                                                class="badge bg-soft-danger text-danger align-middle ms-1">Out of
                                                Delivery</span></h6>
                                        <p class="text-muted mb-2">These customers can rest assured their order has been
                                            placed.</p>
                                        <small class="mb-0 text-muted">16 Nov</small>
                                    </div>
                                </div>
                                <div class="acitivity-item py-3 d-flex">
                                    <div class="flex-shrink-0">
                                        <img src="{{ URL::asset('assets/images/users/avatar-7.jpg') }}" alt=""
                                            class="avatar-xs rounded-circle acitivity-avatar" />
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">Lewis Pratt</h6>
                                        <p class="text-muted mb-2">They all have something to say beyond the words on the
                                            page. They can come across as casual or neutral, exotic or graphic. </p>
                                        <small class="mb-0 text-muted">22 Oct</small>
                                    </div>
                                </div>
                                <div class="acitivity-item py-3 d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-xs acitivity-avatar">
                                            <div class="avatar-title rounded-circle bg-soft-info text-info">
                                                <i class="ri-line-chart-line"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">Monthly sales report</h6>
                                        <p class="text-muted mb-2"><span class="text-danger">2 days left</span>
                                            notification to submit the monthly sales report. <a href="javascript:void(0);"
                                                class="link-warning text-decoration-underline">Reports Builder</a></p>
                                        <small class="mb-0 text-muted">15 Oct</small>
                                    </div>
                                </div>
                                <div class="acitivity-item d-flex">
                                    <div class="flex-shrink-0">
                                        <img src="{{ URL::asset('assets/images/users/avatar-8.jpg') }}" alt=""
                                            class="avatar-xs rounded-circle acitivity-avatar" />
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">New ticket received <span
                                                class="badge bg-soft-success text-success align-middle">Completed</span>
                                        </h6>
                                        <p class="text-muted mb-2">User <span class="text-secondary">Erica245</span>
                                            submitted a ticket.</p>
                                        <small class="mb-0 text-muted">26 Aug</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                <!-- end tab pane -->

                <div class="tab-pane fade" id="project-dashboard" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xxl-3">
                                    <div class="card card-height-100">
                                        <div class="card-header border-0 align-items-center d-flex">
                                            <p class="text-uppercase fw-semibold fs-12 mb-1">All projects by completion
                                                status</p>
                                        </div><!-- end cardheader -->
                                        <div class="card-body">
                                            <div id="portfolio_donut_charts"
                                                data-colors='["--vz-secondary", "--vz-success", "--vz-primary", "--vz-dark", "--vz-warning", "--vz-danger"]'
                                                class="apex-charts" dir="ltr"></div>

                                            <ul class="list-group list-group-flush border-dashed mb-0 mt-3 pt-2">
                                                <li class="list-group-item px-0">
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1 ms-2">
                                                            <p class="fs-12 mb-0 text-muted">
                                                                <i
                                                                    class="mdi mdi-circle fs-10 align-middle text-secondary me-1"></i>
                                                                Pending
                                                            </p>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <p class="text-primary fs-12 mb-0">{{ $pending_cnt }}</p>
                                                        </div>
                                                    </div>
                                                </li><!-- end -->

                                                <li class="list-group-item px-0">
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1 ms-2">
                                                            <p class="fs-12 mb-0 text-muted">
                                                                <i
                                                                    class="mdi mdi-circle fs-10 align-middle text-success me-1"></i>
                                                                InProgress
                                                            </p>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <p class="text-primary fs-12 mb-0">{{ $inprogress_cnt }}</p>
                                                        </div>
                                                    </div>
                                                </li><!-- end -->

                                                <li class="list-group-item px-0">
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1 ms-2">
                                                            <p class="fs-12 mb-0 text-muted">
                                                                <i
                                                                    class="mdi mdi-circle fs-10 align-middle text-primary me-1"></i>
                                                                Completed
                                                            </p>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <p class="text-primary fs-12 mb-0">{{ $completed_cnt }}</p>
                                                        </div>
                                                    </div>
                                                </li><!-- end -->


                                                <li class="list-group-item px-0">
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1 ms-2">
                                                            <p class="fs-12 mb-0 text-muted">
                                                                <i
                                                                    class="mdi mdi-circle fs-10 align-middle text-dark me-1"></i>
                                                                Not Yet Started
                                                            </p>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <p class="text-primary fs-12 mb-0">{{ $notyetstarted_cnt }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li><!-- end -->

                                                <li class="list-group-item px-0">
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1 ms-2">
                                                            <p class="fs-12 mb-0 text-muted">
                                                                <i
                                                                    class="mdi mdi-circle fs-10 align-middle text-warning me-1"></i>
                                                                Overdue
                                                            </p>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <p class="text-primary fs-12 mb-0">{{ $overdue_cnt }}</p>
                                                        </div>
                                                    </div>
                                                </li><!-- end -->

                                                <li class="list-group-item px-0">
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1 ms-2">
                                                            <p class="fs-12 mb-0 text-muted">
                                                                <i
                                                                    class="mdi mdi-circle fs-10 align-middle text-danger me-1"></i>
                                                                Cancelled
                                                            </p>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <p class="text-primary fs-12 mb-0">{{ $cancelled_cnt }}</p>
                                                        </div>
                                                    </div>
                                                </li><!-- end -->

                                            </ul><!-- end -->
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->
                                <div class="col-xxl-9 order-xxl-0 order-first" id="chart">
                                </div><!-- end col -->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-soft-primary">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="flex-grow-1">
                            <div class="hstack text-nowrap gap-2">
                                Projects <span
                                    class="badge badge-danger badge-soft-secondary">{{ count($big_project->projects) }}</span>
                            </div>
                        </div>

                        @if (\App\Helper\Helper::clinicProjectCreatable(auth()->user(), $big_project))
                            <div class="flex-shrink-0">
                                <a href="{{ url('project/create/' . $big_project->id) }}" class="btn btn-info add-btn">
                                    <i class="ri-add-fill me-1 align-bottom"></i> Create Project</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- end col -->
                        @foreach ($big_project->projects as $item)
                            <div class="col-xxl-3 col-sm-6 project-card">
                                <div class="card ribbon-box border ribbon-fill shadow-none mb-lg-2 mb-2">
                                    <div class="card-body">
                                        @if (\App\Helper\Helper::isNew($item->created_at))
                                            <div class="ribbon ribbon-danger">New</div>
                                        @endif
                                        <div class="p-3 mt-n3 mx-n3 bg-soft-secondary rounded-top">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <h5 class="mb-0 fs-14 text-center">
                                                        <a href="{{ url('project/detail/' . $item->id) }}"
                                                            class="text-dark">
                                                            {{ \Illuminate\Support\Str::limit($item->name, 45, $end = '...') }}
                                                        </a>
                                                    </h5>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex gap-1 align-items-center my-n2">
                                                        <div class="dropdown">
                                                            <button
                                                                class="btn btn-link text-muted p-1 mt-n1 py-0 text-decoration-none fs-15"
                                                                data-bs-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="true">
                                                                <i data-feather="more-horizontal" class="icon-sm"></i>
                                                            </button>

                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a class="dropdown-item"
                                                                    href="{{ url('project/detail/' . $item->id) }}"><i
                                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                                    View</a>

                                                                @if (\App\Helper\Helper::clinicProjectEditable(auth()->user(), $item))
                                                                    <a class="dropdown-item"
                                                                        href="{{ url('project/edit/' . $item->id) }}"><i
                                                                            class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                                        Edit</a>
                                                                    <div class="dropdown-divider"></div>
                                                                    <button class="dropdown-item" data-bs-toggle="modal"
                                                                        data-bs-target="#removeProjectModal"
                                                                        onclick="open_modal_delete_bigproject({{ $item->id }})"><i
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
                                                        <div
                                                            class="badge badge-soft-{{ \App\Helper\Helper::getStatusColor($item->status) }} fs-12">
                                                            {{ config('constants.project_status')[$item->status] }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div>
                                                        <p class="text-muted mb-1">Deadline</p>
                                                        <h5 class="fs-14">
                                                            {{ $item->end_date ? date('D j M, Y', strtotime($item->end_date)) : 'Continue' }}
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-center mt-3">
                                                <p class="text-muted mb-0 me-2">Leader :</p>
                                                <div class="avatar-group">
                                                    <a href="javascript: void(0);" class="avatar-group-item"
                                                        data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                        data-bs-placement="top" title="{{ $item->user->name }}">
                                                        {!! \App\Helper\Helper::avatar(
                                                            $item->user->avatar,
                                                            $item->user->name,
                                                            'avatar-xxs',
                                                            11,
                                                            auth() && auth()->user()->id === $item->user->id,
                                                        ) !!}
                                                    </a>
                                                </div>

                                                <p class="text-muted ms-auto mb-0 me-2">Tasks : <span
                                                        class="badge badge-soft-secondary">
                                                        {{ $item->tasks->count() }}</span></p>
                                            </div>

                                            <div class="d-flex align-items-center mt-3">
                                                <p class="text-muted mb-0 me-2">Team :</p>
                                                <div class="avatar-group">
                                                    @foreach ($item->assignUsers as $member)
                                                        <a href="javascript: void(0);" class="avatar-group-item"
                                                            data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                            data-bs-placement="top" title="{{ $member->name }}">
                                                            {!! \App\Helper\Helper::avatar(
                                                                $member->avatar,
                                                                $member->name,
                                                                'avatar-xxs',
                                                                11,
                                                                auth() && auth()->user()->id === $member->id,
                                                            ) !!}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @if (\App\Helper\Helper::progress($item) >= 0)
                                            <div>
                                                <div class="d-flex mb-2">
                                                    <div class="flex-grow-1">
                                                        <div>Progress</div>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div>{{ \App\Helper\Helper::progress($item) }}%</div>
                                                    </div>
                                                </div>

                                                <div class="progress progress-sm animated-progress">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        aria-valuenow="{{ \App\Helper\Helper::progress($item) }}"
                                                        aria-valuemin="0" aria-valuemax="100"
                                                        style="width: {{ \App\Helper\Helper::progress($item) }}%;">
                                                    </div><!-- /.progress-bar -->
                                                </div><!-- /.progress -->
                                            </div>
                                        @endif
                                        <div class="mt-3 d-flex justify-content-end">
                                            <div class="badge badge-soft-dark">{{ $item->department->name }}</div>
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
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="inviteMembersModal" tabindex="-1" aria-labelledby="inviteMembersModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-3 ps-4 bg-soft-success">
                    <h5 class="modal-title" id="inviteMembersModalLabel">Leaders</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="form" method="post" action="{{ url('bigproject/invite/' . $big_project->id) }}">
                        <input name="id" type="hidden" value="{{ $big_project->id }}">
                        @csrf
                    </form>
                    <div class="search-box mb-3">
                        <input id="member_search" type="text" class="form-control bg-light border-light"
                            placeholder="Search here...">
                        <i class="ri-search-line search-icon"></i>
                    </div>

                    <div class="mb-4 d-flex align-items-center">
                        <div class="me-2">
                            <h5 class="mb-0 fs-13">Leaders :</h5>
                        </div>
                        <div class="avatar-group justify-content-center leaders_on_modal"></div>
                    </div>
                    <div class="mx-n4 px-4" data-simplebar style="max-height: 225px;">
                        <div class="vstack gap-3" id="members_container">
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
    <!-- Modal -->
    <div class="modal fade" id="inviteManagerModal" tabindex="-1" aria-labelledby="inviteManagerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-3 ps-4 bg-soft-success">
                    <h5 class="modal-title" id="inviteManagerModalLabel">Managers</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="form_manager" method="post" action="{{ url('bigproject/invite_manager/' . $big_project->id) }}">
                        <input name="id" type="hidden" value="{{ $big_project->id }}">
                        @csrf
                    </form>
                    <div class="search-box mb-3">
                        <input id="member_search" type="text" class="form-control bg-light border-light"
                            placeholder="Search here...">
                        <i class="ri-search-line search-icon"></i>
                    </div>

                    <div class="mb-4 d-flex align-items-center">
                        <div class="me-2">
                            <h5 class="mb-0 fs-13">Managers :</h5>
                        </div>
                        <div class="avatar-group justify-content-center managers_on_modal"></div>
                    </div>
                    <div class="mx-n4 px-4" data-simplebar style="max-height: 225px;">
                        <div class="vstack gap-3" id="manager_container">
                        </div>
                        <!-- end list -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light w-xs" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success w-xs" onclick="invite_manager()">Invite</button>
                </div>
            </div>
            <!-- end modal-content -->
        </div>
        <!-- modal-dialog -->
    </div>
    <!-- end modal -->


    <div id="modal_delete_leader" class="modal bs-example-modal-center" tabindex="-1" role="dialog"
        aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                        colors="primary:#f7b84b,secondary:#f06548" style="width:120px;height:120px">
                    </lord-icon>
                    <div class="mt-0">
                        <div class="fs-15 mx-5">
                            <h4 class="mb-3">Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you Sure You want to Delete this leader ?</p>
                        </div>
                    </div>
                    <div class="hstack gap-2 justify-content-center mt-3">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                        <form method="post" action="{{ url('bigproject/delete_leader/' . $big_project->id) }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="leader_id" value="">
                            <input type="hidden" name="big_project_id" value="{{ $big_project->id }}">
                            <button type="submit" href="javascript:void(0);" class="btn btn-danger">Yes, Delete
                                It!</button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div id="modal_delete_manager" class="modal bs-example-modal-center" tabindex="-1" role="dialog"
        aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                        colors="primary:#f7b84b,secondary:#f06548" style="width:120px;height:120px">
                    </lord-icon>
                    <div class="mt-0">
                        <div class="fs-15 mx-5">
                            <h4 class="mb-3">Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you Sure You want to Delete this manager ?</p>
                        </div>
                    </div>
                    <div class="hstack gap-2 justify-content-center mt-3">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                        <form method="post" action="{{ url('bigproject/delete_manager/' . $big_project->id) }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="manager_id" value="">
                            <input type="hidden" name="big_project_id" value="{{ $big_project->id }}">
                            <button type="submit" href="javascript:void(0);" class="btn btn-danger">Yes, Delete
                                It!</button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



    <div id="modal_delete_attachment" class="modal bs-example-modal-center" tabindex="-1" role="dialog"
        aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                        colors="primary:#f7b84b,secondary:#f06548" style="width:120px;height:120px">
                    </lord-icon>
                    <div class="mt-0">
                        <div class="fs-15 mx-5">
                            <h4 class="mb-3">Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you Sure You want to Delete this file ?</p>
                        </div>
                    </div>
                    <div class="hstack gap-2 justify-content-center mt-3">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                        <form method="post" action="{{ url('bigproject/delete_attachment/' . $big_project->id) }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="attachment_id" value="">
                            <input type="hidden" name="path_name" value="">
                            <input type="hidden" name="big_project_id" value="{{ $big_project->id }}">
                            <button type="submit" href="javascript:void(0);" class="btn btn-danger">Yes, Delete
                                It!</button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal -->
    <div class="modal fade" id="modal_uplaod" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-3 ps-4 bg-soft-success">
                    <h5 class="modal-title">Upload</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form" method="post" action="{{ url('bigproject/upload_file/' . $big_project->id) }}"
                    enctype="multipart/form-data">
                    <div class="modal-body p-4">
                        <input name="id" type="hidden" value="{{ $big_project->id }}">
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
    <div id="removeProjectModal" class="modal zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="form_delete_project" method="post" action="{{ url('project/delete_project') }}">
                @csrf
                <input type="hidden" value="" name="project_id">
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
                            <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Project ?</p>
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



    <div class="modal fade zoomIn" id="edit_modal" tabindex="-1" aria-labelledby="editbigprojectmodal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-soft-info">
                    <h5 class="modal-title" id="editbigprojectmodal">Description</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <form id="edit_task" action="{{ url('bigproject/m_edit') }}" method="post" class="needs-validation"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{ $big_project->id }}" name="id">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label" for="project-title-input">Big Project Title</label>
                                    <input name="name" type="text" class="form-control" id="project-title-input"
                                        value="{{ $big_project->name }}" placeholder="Enter big project title">
                                </div>
                                <div class="mb-3">
                                    <div class="snow-editor" id="ckeditor-classic" style="height: 300px">
                                        {!! $big_project->description !!}</div>
                                </div>
                            </div>
                        </div>
                        <!--end row-->

                        <div class="row">
                            <div class="col-lg-4">
                                <div>
                                    <label for="datepicker-start-input" class="form-label">StartDate</label>
                                    <input name="start_date" value="{{ $big_project->start_date }}" type="text"
                                        class="form-control" id="datepicker-start-input" placeholder="Enter due date"
                                        data-provider="flatpickr">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div>
                                    <label for="datepicker-deadline-input" class="form-label">EndDate</label>
                                    <input name="end_date" value="{{ $big_project->end_date }}" type="text"
                                        class="form-control" id="datepicker-deadline-input" placeholder="Enter due date"
                                        data-provider="flatpickr">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 flex-wrap">
                            <button type="button" class="btn btn-light" id="close-modal" data-bs-dismiss="modal">Close
                            </button>
                            <button type="button" class="btn btn-success" id="edit-btn">Edit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/project-overview.init.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection


@section('script-bottom')
    <script>
        $(document).ajaxSend(function() {
            $("#overlay").fadeIn(50);
        });

        let candidate_user_list = @json($members);
        let user_list = @json($big_project->assignUsers);

        let candidate_user_list_manager = @json($members);
        let user_list_manager = @json($big_project->assignManagers);

        { // invite leader
            function add_user(obj, i) {
                var user = candidate_user_list[i];
                if (!push_user(user)) {
                    add_leader_at_top_modal(user);
                    $(obj).text("Remove");
                } else {
                    delete_leader_at_top_modal(user);
                    $(obj).text("Add");
                }
            }
            function add_manager(obj, i) {
                var user = candidate_user_list_manager[i];
                if (!push_manager(user)) {
                    add_manager_at_top_modal(user);
                    $(obj).text("Remove");
                } else {
                    delete_manager_at_top_modal(user);
                    $(obj).text("Add");
                }
            }

            function push_user(user) {
                var status = false;
                for (var i = 0; i < user_list.length; i++) {
                    var id = user_list[i].id;
                    if (id == user.id) {
                        status = true;
                        break;
                    }
                }
                if (!status)
                    user_list.push(user);
                else { // if exists
                    Utils.removeByAttr(user_list, 'id', user.id);
                }
                return status;
            }
            function push_manager(user) {
                var status = false;
                for (var i = 0; i < user_list_manager.length; i++) {
                    var id = user_list_manager[i].id;
                    if (id == user.id) {
                        status = true;
                        break;
                    }
                }
                if (!status)
                    user_list_manager.push(user);
                else { // if exists
                    Utils.removeByAttr(user_list_manager, 'id', user.id);
                }
                return status;
            }

            function delete_leader_at_top_modal(user) {
                $('.leaders_on_modal').empty();
                for (var i = 0; i < user_list.length; i++)
                    $('.leaders_on_modal').append(avatar(user_list[i]));
            }
            function delete_manager_at_top_modal(user) {
                $('.managers_on_modal').empty();
                for (var i = 0; i < user_list_manager.length; i++)
                    $('.managers_on_modal').append(avatar(user_list_manager[i]));
            }

            function html_candidate_item(candidate, text, i) {
                var html = '<div class="d-flex align-items-center member_item">\
                        <div class="avatar-xs flex-shrink-0 me-3">\
                            ' + avatar(candidate) + '\
                        </div>\
                        <div class="flex-grow-1">\
                            <h5 class="fs-13 mb-0"><a href="#" class="text-body d-block name"> ' + candidate.name + '</a>\
                            </h5>\
                        </div>\
                        <div class="flex-shrink-0">\
                            <a type="button" class="btn btn-light btn-sm" onclick="add_user(this, ' + i + ')">' + text + '</a>\
                        </div>\
                    </div>';
                return html;
            }
            function html_manager_item(manager, text, i) {
                var html = '<div class="d-flex align-items-center member_item">\
                        <div class="avatar-xs flex-shrink-0 me-3">\
                            ' + avatar(manager) + '\
                        </div>\
                        <div class="flex-grow-1">\
                            <h5 class="fs-13 mb-0"><a href="#" class="text-body d-block name"> ' + manager.name + '</a>\
                            </h5>\
                        </div>\
                        <div class="flex-shrink-0">\
                            <a type="button" class="btn btn-light btn-sm" onclick="add_manager(this, ' + i + ')">' + text + '</a>\
                        </div>\
                    </div>';
                return html;
            }

            function update_modal(user_list) {
                $('.leaders_on_modal').empty();
                for (let i = 0; i < user_list.length; i++) {
                    let item = user_list[i];
                    $('.leaders_on_modal').append(avatar(item));
                }

                $('#members_container').empty();

                for (let i = 0; i < candidate_user_list.length; i++) {
                    let item = candidate_user_list[i];
                    var isExited = false;
                    for (var j = 0; j < user_list.length; j++) {
                        if (user_list[j].id === item.id) {
                            isExited = true;
                            break;
                        }
                    }
                    if (isExited) {
                        $('#members_container').append(html_candidate_item(item, "Remove", i));
                    } else
                        $('#members_container').append(html_candidate_item(item, "Add", i));
                }


            }
            function update_modal_manager(user_list_manager) {
                $('.managers_on_modal').empty();
                for (let i = 0; i < user_list_manager.length; i++) {
                    let item = user_list_manager[i];
                    $('.managers_on_modal').append(avatar(item));
                }

                $('#manager_container').empty();

                for (let i = 0; i < candidate_user_list_manager.length; i++) {
                    let item = candidate_user_list_manager[i];
                    var isExited = false;
                    for (var j = 0; j < user_list_manager.length; j++) {
                        if (user_list_manager[j].id === item.id) {
                            isExited = true;
                            break;
                        }
                    }
                    if (isExited) {
                        $('#manager_container').append(html_manager_item(item, "Remove", i));
                    } else
                        $('#manager_container').append(html_manager_item(item, "Add", i));
                }


            }

            function add_leader_at_top_modal(user) {
                $('.leaders_on_modal').append(avatar(user));
            }
            function add_manager_at_top_modal(user) {
                $('.managers_on_modal').append(avatar(user));
            }

            function avatar(user, size = 'avatar-xs') {
                let clientNameBothLetters = user.name.split(" ")[0][0];
                if (user.name.split(" ").length > 1)
                    clientNameBothLetters = user.name.split(" ")[0][0] +
                    user.name.split(" ")[user.name.split(" ").length - 1][0];

                let leader = '<a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"\
                                    data-bs-trigger="hover" data-bs-placement="top" title="'+user.name+'">\
                                        <div class="' + size + '">\
                                            <img src="{{ URL::asset('public/images/') }}/' + user.avatar + '" alt="" class="rounded-circle img-fluid">\
                                        </div>\
                                  </a>';

                if (user.avatar === 'user_default.jpg')
                    leader =
                    '<a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"\
                                    data-bs-trigger="hover" data-bs-placement="top" title="'+user.name+'">\
                                        <div class="avatar-xs">\
                                            <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' +
                    user.name + '" class="' + size +
                    ' me-0 d-inline-block">\
                                            <div class="avatar-title rounded-circle bg-secondary text-white text-uppercase">' +
                    clientNameBothLetters + '</div>\
                                        </div>\
                                        </div>\
                                  </a>';
                return leader;
            }



            function open_invite_modal() {
                $('#inviteMembersModal').modal('show');
                update_modal(user_list);
            }

            function open_invite_modal_manager() {
                $('#inviteManagerModal').modal('show');
                update_modal_manager(user_list_manager);
            }

            function invite() {
                if (user_list.length === 0) {
                    notification("Please select assignee.");
                    return;
                }
                $.each(user_list, function(i, item) {
                    var html_userlist = $("<input>")
                        .attr("type", "hidden")
                        .attr("name", "assignedTo[]").val(item.id);
                    $('#form').append(html_userlist);
                });
                $("#form").submit();
            }
            function invite_manager() {
                if (user_list_manager.length === 0) {
                    notification("Please select manager.");
                    return;
                }
                $.each(user_list_manager, function(i, item) {
                    var html_userlist = $("<input>")
                        .attr("type", "hidden")
                        .attr("name", "assignedTo[]").val(item.id);
                    $('#form_manager').append(html_userlist);
                });
                $("#form_manager").submit();
            }
        }

        { // delete leader
            var modal_delete_leader = $('#modal_delete_leader');

            function delete_deader(id) {
                $('input[name="leader_id"]').val(id);
                modal_delete_leader.modal("show");
            }
            var modal_delete_manager = $('#modal_delete_manager');

            function delete_manager(id) {
                $('input[name="manager_id"]').val(id);
                modal_delete_manager.modal("show");
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

            function open_modal_uplaod() {
                modal_uplaod.modal("show");
            }
        }

        { // remove project
            function open_modal_delete_bigproject(id) {
                $('input[name="project_id"]').val(id);
                $('#removeProjectModal').modal('show');
            }

            $('#remove-project').click(function() {
                $('#form_delete_project').submit();
            });
        }

        { //circle chart
            var donutchartportfolioColors = ['#3577f1', '#0ab39c', '#405189',
                '#212529', '#f7b84b', '#f06548'
            ];

            var options = {
                series: [{{ $pending_cnt }}, {{ $inprogress_cnt }}, {{ $completed_cnt }},
                    {{ $notyetstarted_cnt }}, {{ $overdue_cnt }}, {{ $cancelled_cnt }}
                ],
                labels: ["Pending", "InpProgress", "Completed", "Not Yet Started", "Overdue", "Cancelled"],
                chart: {
                    type: "donut",
                    height: 224
                },
                plotOptions: {
                    pie: {
                        size: 100,
                        offsetX: 0,
                        offsetY: 0,
                        donut: {
                            // size: "70%",
                            labels: {
                                show: true,
                                name: {
                                    show: true,
                                    fontSize: "18px",
                                    offsetY: -5
                                },
                                value: {
                                    show: true,
                                    fontSize: "20px",
                                    color: "#343a40",
                                    fontWeight: 500,
                                    offsetY: 5,
                                    formatter: function formatter(val) {
                                        return val;
                                    }
                                },
                                total: {
                                    show: true,
                                    fontSize: "13px",
                                    label: "Total",
                                    color: "#9599ad",
                                    fontWeight: 500,
                                    formatter: function formatter(w) {
                                        return w.globals.seriesTotals.reduce(function(a, b) {
                                            return a + b;
                                        }, 0);
                                    }
                                }
                            }
                        }
                    }
                },
                dataLabels: {
                    enabled: true,
                    dropShadow: {
                        enabled: false
                    }
                },
                legend: {
                    show: false
                },
                yaxis: {
                    labels: {
                        formatter: function formatter(value) {
                            return value;
                        }
                    }
                },
                stroke: {
                    lineCap: "round",
                    width: 2
                },
                colors: donutchartportfolioColors
            };
            var chart = new ApexCharts(document.querySelector("#portfolio_donut_charts"), options);
            chart.render();

        }

        { // search
            $("#member_search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#members_container .member_item").css("display", function() {
                    if ($(this).find('a.name').text().toLowerCase().indexOf(value) > -1) {
                        $(this).removeClass("d-none").addClass("d-flex");
                    } else {
                        $(this).removeClass("d-flex").addClass("d-none");
                    }
                });
            });
        }


        let myEditor;
        $(document).ready(function() {
            var snowEditor = document.querySelector(".snow-editor");
            var snowEditorData = {};
            snowEditorData.theme = 'snow', snowEditorData.modules = {
                'toolbar': [
                    [{
                        'font': []
                    }, {
                        'size': []
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                        'color': []
                    }, {
                        'background': []
                    }],
                    [{
                        'script': 'super'
                    }, {
                        'script': 'sub'
                    }],
                    [{
                        'header': [false, 1, 2, 3, 4, 5, 6]
                    }, 'blockquote', 'code-block'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }, {
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }],
                    ['direction', {
                        'align': []
                    }],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            };
            myEditor = new Quill(snowEditor, snowEditorData);


            $.ajax({
                url: '{{ url('bigproject/chart') }}',
                method: 'post',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: {{ $big_project->id }},
                    year: $(this).val(),
                },
                success: function(response) {
                    $('#chart').empty();
                    $('#chart').html(response);
                },
                error: function(response) {

                },
                failure: function(response) {

                }
            }).done(function() {
                setTimeout(function() {
                    $("#overlay").fadeOut(200);
                }, 500);
            });
        });


        { // submit
            $('#edit-btn').click(function() {
                let name = $('input[name="name"]').val();
                let start_date = $('input[name="start_date"]').val();
                let end_date = $('input[name="end_date"]').val();

                if (name === "") {
                    notification("Please input task title");
                    return;
                }

                var description = myEditor.container.firstChild.innerHTML;
                if (description === "<p><br></p>") {
                    notification("Please input description of the project.");
                    return;
                }
                var html_description = $("<input>")
                    .attr("type", "hidden")
                    .attr("name", "description").val(description);
                $('#edit_task').append(html_description);

                if (start_date === "") {
                    notification("Please select start date.");
                    return;
                }

                if (start_date !== "" && end_date !== "") {
                    if (parseInt(start_date.replace(/-/g, ""), 10) > parseInt(end_date.replace(/-/g, ""), 10)) {
                        notification("The end date has to be later regarding to start date");
                        return;
                    }
                }

                $('#edit_task').submit();
            });
        }


        { // change status
            $('#change_status').change(function() {
                $('#form_status').submit();
            });
        }
    </script>
@endsection
