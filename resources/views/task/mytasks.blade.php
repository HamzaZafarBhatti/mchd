@extends('layouts.master')
@section('title') @lang('translation.projects') @endsection
@section('content')

@component('components.breadcrumb')
{{--    @slot('li_1') Task @endslot--}}
    @slot('title') Task  @endslot
@endcomponent

@include('layouts.flash-message')
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1 py-1">My Tasks</h4>
{{--                    <div class="flex-shrink-0">--}}
{{--                        <div class="dropdown card-header-dropdown">--}}
{{--                            <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown"--}}
{{--                               aria-haspopup="true" aria-expanded="false">--}}
{{--                                <span class="text-muted">All Tasks <i--}}
{{--                                        class="mdi mdi-chevron-down ms-1"></i></span>--}}
{{--                            </a>--}}
{{--                            <div class="dropdown-menu dropdown-menu-end">--}}
{{--                                @foreach(config('constants.task_status') as $key => $val)--}}
{{--                                    <a class="dropdown-item" href="#">{{$val}}</a>--}}
{{--                                @endforeach--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table
                            class="table table-borderless table-nowrap table-centered align-middle mb-0">
                            <thead class="table-light text-muted">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Dedline</th>
                                <th scope="col">Status</th>
                                <th scope="col">Assignee</th>
                            </tr>
                            </thead><!-- end thead -->
                            <tbody>
                            @foreach($tasks as $item)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <label class="form-check-label ms-1">
                                                {{$item->name}}
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-muted">{{$item->end_date}}</td>

                                    <td>
                                        <span class="badge badge-soft-{{config('constants.status_color')[$item->status]}}">
                                            {{config('constants.task_status')[$item->status]}}
                                        </span>
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
                                </tr><!-- end -->
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
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->
@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/pages/dashboard-projects.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
