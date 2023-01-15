@extends('layouts.master')
@section('title') @lang('translation.projects') @endsection
@section('content')
    @component('components.main_breadcrumb')
            @slot('li_1') Admin Panel @endslot
        @slot('title') User Management  @endslot
    @endcomponent
    @include('layouts.errors')
    @include('layouts.flash-message')
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1 py-1">Users</h4>
                    <div class="flex-shrink-0">
                        <div class="dropdown card-header-dropdown">
                            <form method="get" id="form_code">
                                <label>
                                    <select name="code" class="form-select form-select-sm" id="sel_department">
                                        <option {{$code == -1 ? 'selected' : ''}} value="">All</option>
                                        @foreach($departments as $item)
                                            <option {{$code == $item->code ? 'selected' : ''}} value="{{$item->code}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </label>
                            </form>
                        </div>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-nowrap table-centered align-middle mb-0">
                            <thead class="table-light text-muted">
                            <tr>
                                <th scope="col">Avatar</th>
                                <th scope="col">@sortablelink('department.name', 'Department')
                                    @if($sort=='department.name')
                                        @if($direction=='asc')
                                            <i class="las la-sort-alpha-up"></i>
                                        @else
                                            <i class="las la-sort-alpha-down"></i>
                                        @endif
                                    @endif
                                </th>

                                <th scope="col">@sortablelink('name', 'Name')
                                    @if($sort=='name')
                                        @if($direction=='asc')
                                            <i class="las la-sort-alpha-up"></i>
                                        @else
                                            <i class="las la-sort-alpha-down"></i>
                                        @endif
                                    @endif
                                </th>
                                <th scope="col">Email</th>
                                <th scope="col">ReadOnly</th>
                                <th scope="col">Status Changeable</th>
                                <th scope="col">Other Creatable</th>
                                <th scope="col">@sortablelink('role', 'Permission')
                                    @if($sort=='role')
                                        @if($direction=='asc')
                                            <i class="las la-sort-alpha-up"></i>
                                        @else
                                            <i class="las la-sort-alpha-down"></i>
                                        @endif
                                    @endif
                                </th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                                <th scope="col">Remove</th>
                            </tr>
                            </thead><!-- end thead -->
                            <tbody>

                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <div class="avatar-group-item">
                                                <a href="{{url('admin/users/'.$user->id)}}" class="d-inline-block">
                                                    {!! \App\Helper\Helper::avatar($user->avatar, $user->name) !!}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-muted">
                                       <span class="{{$user->role == 1? 'badge badge-soft-primary' : ''}}">
                                           {{$user->department->name}}
                                       </span>
                                    </td>
                                    <td class="text-muted">
                                        <span class="{{$user->role == 1? 'badge badge-soft-primary' : ''}}">
                                            {{$user->name}}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="{{$user->role == 1? 'badge badge-soft-primary' : ''}}">
                                        {{$user->email}}
                                        </span>
                                    </td>
                                    <td class="">
                                        <span class="badge bg-primary rounded-pill">{{$user->department->name}}</span><br>
                                        @foreach($user->details->where('type', 1) as $item)
                                            <span class="badge bg-primary rounded-pill">{{$item->department->name}}</span><br>
                                        @endforeach
                                    </td>
                                    <td class="">
                                        @foreach($departments as $department)
                                            @if($user->role == 1 && $user->department_code == $department->code)
                                                <span class="badge bg-success rounded-pill">{{$user->department->name}}</span><br>
                                            @endif
                                        @endforeach
                                        @foreach($user->details->where('type', 3) as $item)
                                            <span class="badge bg-success rounded-pill">{{$item->department->name}}</span><br>
                                        @endforeach
                                    </td>
                                    <td class="">
                                        @foreach($user->details->where('type', 2) as $item)
                                            <span class="badge bg-secondary rounded-pill">{{$item->department->name}}</span><br>
                                        @endforeach
                                    </td>
                                    <td>
                                        <form method="post">
                                            @csrf
                                            <label>
                                                <input name="user_id" type="hidden" value="{{$user->id}}">
                                                <select class="form-select form-select-sm" name="role">
                                                    <option {{$user->role == 0? 'selected' : ''}} value="0"></option>
                                                    <option {{$user->role == 1? 'selected' : ''}} value="1">Manager</option>
                                                </select>
                                            </label>
                                        </form>
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-{{$user->allowed?'success':'danger'}}">
                                            {{$user->allowed? "Approved" : "Not Approved"}}
                                        </span>
                                    </td>
                                    <td>
                                        @if($user->allowed)
                                            <a class="btn btn-danger btn-sm" href="{{url('admin/allowed?id='.$user->id)}}">Disapprove</a>
                                        @else
                                            <a class="btn btn-primary btn-sm" href="{{url('admin/allowed?id='.$user->id)}}">Approve</a>
                                        @endif
                                    </td>
                                    <td class="col text-center">
                                        <a href="javascript:remove_user({{$user->id}})">
                                            <i class="las la-trash text-danger" style="font-size: 22pt"></i>
                                        </a>
                                    </td>
                                </tr><!-- end -->
                            @endforeach
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->
                    </div>
                    <div class="align-items-center mt-xl-3 mt-4 justify-content-between d-flex">
                        <div class="flex-shrink-0">
                            <div class="text-muted">Showing <span class="fw-semibold">{{$users->count()}}</span> of <span
                                    class="fw-semibold"> {{$users->total()}}</span> Results
                            </div>
                        </div>
                        {!! $users->appends(['code' => $code, 'sort' => $sort, 'direction' => $direction])->links('vendor.pagination.custom')->render() !!}
                    </div>

                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->



    <div class="modal fade bs-example-modal-center modal_remove_user" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json"
                               trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:120px;height:120px">
                    </lord-icon>
                    <div class="mt-0">
                        <div class="fs-15 mx-5">
                            <h4 class="mb-3">Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you Sure You want to Delete this User ?</p>
                        </div>
                    </div>
                    <div class="hstack gap-2 justify-content-center mt-3">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                        <form method="post" action="{{url('admin/remove_user')}}">
                            @csrf
                            <input type="hidden" name="user_id" value="">
                            <button type="submit" href="javascript:void(0);" class="btn btn-danger">Yes, Delete It!</button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script>
        $('#sel_department').change(function () {
            $("#form_code").submit();
        });

        $('select[name="role"]').change(function () {
            $(this).parent().parent().submit();
        });

        function remove_user(user_id){
            $('input[name="user_id"]').val(user_id);
            $('.modal_remove_user').modal("show");
        }

        $(function () {})
    </script>
@endsection
