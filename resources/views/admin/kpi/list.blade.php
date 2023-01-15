@extends('layouts.master')
@section('title') @lang('translation.projects') @endsection
@section("css_bottom")
    <style>
        .hiddenRow {
            padding: 0 !important;
        }

        .expandChildTable:before {
            height: 1em;
            width: 1em;
            margin-top: -9px;
            display: block;
            position: absolute;
            color: white;
            border: .15em solid white;
            border-radius: 1em;
            box-shadow: 0 0 .2em #444;
            box-sizing: content-box;
            text-align: center;
            text-indent: 0 !important;
            font-family: "Courier New",Courier,monospace;
            line-height: 1em;
            content: "+";
            background-color: #337ab7;
            cursor: pointer;
        }

        .expandChildTable.selected:before {
            content: "-";
            background-color: #ee4a57;
        }
        tr.childTableRow {
            display: none;
        }
        .description{
            background-color: #F3F3F9;
        }
    </style>
@endsection
@section('content')
    @component('components.main_breadcrumb')
        @slot('title') Kpis  @endslot
        @slot('li_1') Admin panel @endslot
    @endcomponent
    @include('layouts.errors')
    @include('layouts.flash-message')
    <div class="row project-wrapper">
        <div class="col-xxl-12 col-lg-12 col-xl-12 col-md-12">
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4 class="card-title flex-grow-1 mb-0"> Key Performance Indicators</h4>
                            <button class="btn btn-danger btn-sm add-btn" data-bs-toggle="modal"
                                    data-bs-target="#createProjectModal" onclick="add_kpi_modal()"><i
                                    class="ri-add-line align-bottom me-1"></i> Add KPI</button>
                        </div><!-- end cardheader -->

                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table class="table table-nowrap table-centered align-middle text-center">
                                    <thead class="bg-light text-muted">
                                    <tr>
                                        <th></th>
                                        <th scope="col">Group</th>
                                        <th class="col">Criteria</th>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Action</th>
                                    </tr><!-- end tr -->
                                    </thead><!-- thead -->
                                    <tbody>
                                    @foreach($kpis as $item)
                                        <tr>
                                            <td><span class="expandChildTable"></span></td>
                                            <td class="fw-medium">
                                                {{$item->group->name}}
                                            </td>
                                            <td>
                                                {{$item->criteria}}
                                            </td>
                                            <td>
                                                {{$item->unit->name}}
                                            </td>
                                            <td>
                                                <a href="javascript:edit_kpi({{json_encode($item)}})">
                                                    <i style="font-size: 16pt" class="ri-edit-2-fill text-success px-2"></i>
                                                </a>
                                                <a href="javascript:delete_kpi({{json_encode($item)}})">
                                                    <i style="font-size: 16pt" class="ri-delete-bin-6-fill text-danger px-2"></i>
                                                </a>
                                            </td>
                                        </tr><!-- end tr -->
                                        <tr class="childTableRow description text-start">
                                            <td colspan="5">
                                                <div class="py-1 px-2">
                                                    <label>Description</label>
                                                    <p>{{$item->description}}</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody><!-- end tbody -->
                                </table><!-- end table -->
                            </div>

                            <div class="align-items-center mt-xl-3 mt-4 justify-content-between d-flex">
                                <div class="flex-shrink-0">
                                    <div class="text-muted">Showing <span
                                            class="fw-semibold">{{$kpis->count()}}</span> of <span
                                            class="fw-semibold"> {{$kpis->total()}}</span> Results
                                    </div>
                                </div>
                                {!! $kpis->appends([])->links('vendor.pagination.custom')->render() !!}
                            </div>

                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->

            </div>

        </div>
    </div>


    <div class="modal fade zoomIn" id="add_kpi_modal" tabindex="-1" aria-labelledby="createProjectModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-soft-info">
                    <h5 class="modal-title" id="createProjectModelLabel">KPI</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                <form id="create_task" action="{{url('kpi/add_kpi')}}" method="post" class="needs-validation">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="criteria" class="form-label">Criteria</label>
                                <input type="text" id="criteria" class="form-control" name="criteria"
                                       placeholder="Please input criteria"
                                       required/>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 mt-3">
                                <label for="group" class="form-label">Group</label>
                                <select class="form-select" name="group_id" required>
                                    <option></option>
                                    @foreach($groups as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-6 col-md-6 mt-3">
                                <label for="group" class="form-label">Unit</label>
                                <select class="form-select" name="unit_id">
                                    <option value=""></option>
                                    @foreach($units as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                           <div class="">
                               <label for="description" class="form-label">Description</label>
                               <textarea id="description" name="description" rows="6"
                                         class="form-control" placeholder="Please type description."></textarea>
                           </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 flex-wrap">
                            <button type="button" class="btn btn-light" id="close-modal"
                                    data-bs-dismiss="modal">Close
                            </button>
                            <button type="submit" class="btn btn-success" id="add-btn">Post</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="delete_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json"
                               trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:120px;height:120px">
                    </lord-icon>
                    <div class="mt-0">
                        <div class="fs-15 mx-5">
                            <h4 class="mb-3">Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you Sure You want to Delete this item ?</p>
                            <p class="text-muted mx-4 mb-0">All kpis related with this item will be removed. Please confirm again.</p>
                        </div>
                    </div>
                    <div class="hstack gap-2 justify-content-center mt-3">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                        <form method="post" action="{{url('kpi/delete_kpi')}}">
                            @csrf
                            <input type="hidden" name="id" value="">
                            <button type="submit" href="javascript:void(0);" class="btn btn-danger">Yes, Delete It!</button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



    <div class="modal fade zoomIn" id="edit_kpi_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-soft-info">
                    <h5 class="modal-title">KPI</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="create_task" action="{{url('kpi/edit_kpi')}}" method="post" class="needs-validation">
                    {{csrf_field()}}
                    <input name="id" type="hidden">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="criteria" class="form-label">Criteria</label>
                                <input type="text" id="criteria" class="form-control" name="criteria"
                                       placeholder="Please input criteria"
                                       required/>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 mt-3">
                                <label for="group" class="form-label">Group</label>
                                <select class="form-select" name="group_id" required>
                                    <option></option>
                                    @foreach($groups as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-6 col-md-6 mt-3">
                                <label for="group" class="form-label">Unit</label>
                                <select class="form-select" name="unit_id">
                                    <option value=""></option>
                                    @foreach($units as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" name="description" rows="6"
                                          class="form-control" placeholder="Please type description."></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 flex-wrap">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Edit</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('script')

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection

@section('script-bottom')
    <script>
        $(function() {
            $('.expandChildTable').on('click', function() {
                $(this).toggleClass('selected').closest('tr').next().toggle();
            })
        });

        function add_kpi_modal() {
            $("#add_kpi_modal").modal("show");
        }

        function edit_kpi(kpi){
            const {id, criteria, group_id, unit_id, description} = kpi;
            $("#edit_kpi_modal input[name='criteria']").val(criteria);
            $("#edit_kpi_modal select[name='group_id']").val(group_id);
            $("#edit_kpi_modal select[name='unit_id']").val(unit_id);
            $("#edit_kpi_modal textarea[name='description']").val(description);
            $("#edit_kpi_modal input[name='id']").val(id);
            $('#edit_kpi_modal').modal("show");
        }

        function delete_kpi(kpi){
            const {id} = kpi;
            $("input[name='id']").val(id);
            $("#delete_modal").modal("show");
        }
    </script>
@endsection
