@extends('layouts.master')
@section('title') @lang('translation.projects') @endsection
@section('css_bottom')
    <!--datatable css-->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <!--datatable responsive css-->
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="position-relative mx-n4 mt-n4">
        @include('layouts.errors')
        @include('layouts.flash-message')
        <div class="profile-wid-bg profile-setting-img" style="height: 100px">
            {{--            <img src="{{ URL::asset('assets/images/profile-bg.jpg') }}" class="profile-wid-img" alt="">--}}
        </div>
    </div>

    <div class="row">
        <div class="col-xxl-3">
            <div class="card mt-n5">
                <div class="card-body p-4">
                    <div class="text-center">
                        {!! \App\Helper\Helper::avatar($user->avatar, $user->name, 'avatar-xl', 45) !!}
                        <h5 class="fs-16 mb-1">{{$user->name}}</h5>
                        <p class="text-muted mb-0">{{$user->department->name}}</p>
                        @if($user->role == 1)
                            <p class="text-muted mb-0">
                                <span class="badge badge-soft-info">
                                    Manager
                                </span>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-xxl-9">
            <div class="card mt-xxl-n5">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                <i class="fas fa-home"></i>
                                Personal Details
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="firstnameInput" class="form-label">Full
                                            Name</label>
                                        <input type="text" class="form-control" disabled id="firstnameInput"
                                               placeholder="Enter your firstname" value="{{$user->name}}">
                                    </div>
                                </div>
                                <!--end col-->


                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="emailInput" class="form-label">Email
                                            Address</label>
                                        <input type="email" class="form-control" id="emailInput"
                                               placeholder="Enter your email" value="{{$user->email}}" disabled>
                                    </div>
                                </div>
                                <!--end col-->


                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="emailInput" class="form-label">Department</label>
                                        <input type="email" class="form-control"
                                               placeholder="" value="{{$user->department->name}}" disabled>
                                    </div>
                                </div>
                                <!--end col-->

                            <!--end col-->
                            </div>
                            <!--end row-->

                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="table-responsive table-card">
                                        <table class="table table-hover table-striped align-middle table-nowrap mb-0">
                                        <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Code</th>
                                            <th scope="col">Department</th>
                                            <th scope="col">ReadOnly</th>
                                            <th scope="col">Status Changeable</th>
                                            <th scope="col">Other Creatable</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($departments as $department)
                                        <tr>
                                            <th scope="row">{{$department->code}}</th>
                                            <td>{{$department->name}}</td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    @if($department->code == $user->department_code || $user->role == 2)
                                                        <input class="form-check-input" data-code="{{$department->code}}" type="checkbox" role="switch" checked disabled>
                                                    @else
                                                        <input class="form-check-input" data-code="{{$department->code}}" type="checkbox" onchange="onChanged(this, {{$department->code}}, 1)" role="switch" {{$user->details->where("department_code", $department->code)->where('type', 1)->count()? 'checked': ''}}>
                                                    @endif
                                                </div>
                                            </td>

                                            <td>
                                                <div class="form-check form-switch">
                                                    @if(($user->role == 2) || // super admin
                                                        ($user->department_code == $department->code && $user->role == 1))
                                                        <input class="form-check-input" data-code="{{$department->code}}" type="checkbox" role="switch" checked disabled>
                                                    @else
                                                        <input class="form-check-input" data-code="{{$department->code}}" type="checkbox" onchange="onChanged(this, {{$department->code}}, 3)" role="switch" {{$user->details->where("department_code", $department->code)->where('type', 3)->count()? 'checked': ''}}>
                                                    @endif
                                                </div>
                                            </td>

                                            <td>
                                                <div class="form-check form-switch">
                                                    @if(($user->role == 2) || // super admin
                                                        ($user->department_code == $department->code && $user->role == 1))
                                                        <input class="form-check-input" data-code="{{$department->code}}" type="checkbox" role="switch" checked disabled>
                                                    @else
                                                        <input class="form-check-input" data-code="{{$department->code}}" type="checkbox" onchange="onChanged(this, {{$department->code}}, 2)" role="switch" {{$user->details->where("department_code", $department->code)->where('type', 2)->count()? 'checked': ''}}>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                            <!--end row-->

                            @if($user->role > 0)
                                <div class="row mt-5">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">
                                                    KPI Permission
                                                </h5><br>
                                                <div class="form-check form-switch">
                                                        @if($user->role == 2)
                                                            <input class="form-check-input" data-code="0" type="checkbox" role="switch" checked disabled>
                                                        @else
                                                            <?php
                                                                $is_checked = 1;
                                                                foreach($kpis as $item) {
                                                                    if(!$user->assignedKpis->where("kpi_id", $item->id)->count()) {
                                                                        $is_checked = 0;
                                                                        break;
                                                                    }
                                                                }
                                                            ?>
                                                            <input id="item-all" class="form-check-input" data-code="0" type="checkbox" onchange="onChangedAssignedKpiAll(this)" role="switch" {{$is_checked? 'checked': ''}}>
                                                        @endif
                                                        Assign All
                                                    </div>
                                            </div>
                                            <div class="card-body">
                                                <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                                    <thead class="table-dark">
                                                    <tr>
                                                        <th scope="col">Group</th>
                                                        <th scope="col">Criteria</th>
                                                        <th scope="col">Assigned</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($kpis as $item)
                                                        <tr>
                                                            <th scope="row">{{$item->group->name}}</th>
                                                            <td>{{$item->criteria}}</td>
                                                            <td>
                                                                <div class="form-check form-switch">
                                                                    @if($user->role == 2)
                                                                        <input id="department{{$department->code}}" class="form-check-input" data-code="{{$department->code}}" type="checkbox" role="switch" checked disabled>
                                                                    @else
                                                                        <input id="item{{$item->id}}" class="form-check-input" data-code="{{$item->id}}" type="checkbox" onchange="onChangedAssignedKpi(this, {{$item->id}})" role="switch" {{$user->assignedKpis->where("kpi_id", $item->id)->count()? 'checked': ''}}>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!--end row-->
                            @endif
                        </div>
                        <!--end tab-pane-->
                    </div>
                        <!--end tab-pane-->
                    <!--end row-->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xl-12 text-start">
            <a href="javascript:history.go(-1)" class="btn btn-danger">back</a>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection

@section('script-bottom')
    <script>

        $(document).ready(function() {
            $('#example').DataTable();

        });


        $(document).ajaxSend(function() {
            $("#overlay").fadeIn(50);
        });
        let user_id = {{$user->id}};
        let total_item_count = {{count($kpis)}};
        let active_item = {{$user->assignedKpis->count()}};

        function onChanged(obj, code, type) {
            if ($(obj).is(":checked")){
                changeDetail(user_id, code, 1, type);
            }else {
                changeDetail(user_id, code, 0, type);
            }
        }

        function changeDetail(user_id, code, set = 0, type){
            $.ajax({
                method: 'post',
                url: '{{url('admin/change_detail')}}',
                data: {
                    _token: '{{csrf_token()}}',
                    user_id: user_id,
                    code: code,
                    set: set,
                    type: type
                },
                success: function (response) {
                    if (response.code === 1)
                        notification_success("Changed Successfully");
                    else
                        notification("Unfortunately failed");
                },
                error: function (response){
                    notification("Unfortunately failed");
                }
            }).done(function () {
                setTimeout(function(){
                    $("#overlay").fadeOut(200);
                },500);
            });
        }


        function onChangedAssignedKpi(obj, kpi_id) {
            if ($(obj).is(":checked")){
                changeAssignedKpi(user_id, kpi_id, 1);
                if(++active_item == total_item_count) {
                    document.getElementById("item-all").checked = "checked";
                }
            } else {
                changeAssignedKpi(user_id, kpi_id, 0);
                active_item--;
                document.getElementById("item-all").checked = "";
            }
        }
        
        function onChangedAssignedKpiAll(obj) {
            @foreach($kpis as $item)
                if ($(obj).is(":checked")){
                    changeAssignedKpi(user_id, {{$item->id}}, 1);
                } else {
                    changeAssignedKpi(user_id, {{$item->id}}, 0);
                }
            @endforeach
        }

        function changeAssignedKpi(user_id, kpi_id, set = 0){
            $.ajax({
                method: 'post',
                url: '{{url('admin/change_assign_kpi')}}',
                data: {
                    _token: '{{csrf_token()}}',
                    user_id: user_id,
                    kpi_id: kpi_id,
                    set: set,
                },
                success: function (response) {
                    if (response.code === 1) {
                        if(set == 1) {
                            document.getElementById("item" + kpi_id).checked = "checked";
                        } else {
                            document.getElementById("item" + kpi_id).checked = "";
                        }
                        notification_success("Changed Successfully");
                    } else {
                        notification("Unfortunately failed");
                    }
                },
                error: function (response){
                    notification("Unfortunately failed");
                }
            }).done(function () {
                setTimeout(function(){
                    $("#overlay").fadeOut(200);
                },500);
            });
        }

    </script>
@endsection
