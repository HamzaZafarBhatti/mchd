@extends('layouts.master')
@section('title') @lang('translation.task-details') @endsection
@section('css_bottom')
    <link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/quill/quill.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/@tarekraafat/@tarekraafat.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    @include('layouts.flash-message')
    @include('layouts.errors')
    <div class="row">
        <div class="col-xxl-3">
            <div class="card mb-3">
                <div class="card-body">
                    @if(\App\Helper\Helper::statusChangeable(auth()->user(), $task))
                    <div class="mb-4">
                        <form id="form_status" method="post" action="{{url('tasks/sub_change_status')}}">
                            @csrf
                            <input type="hidden" name="id" value="{{$task->id}}">
                            <select id="change_status" class="form-control" name="status" data-choices data-choices-search-false>
                                @foreach(config('constants.sub_task_status') as $key => $val)
                                    @if($key !== "all")
                                        <option {{$task->status == $key? 'selected' : ''}} value="{{$key}}">{{$val}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </form>
                    </div>
                    @endif
                    <div class="table-card">
                        <table class="table mb-0">
                            <tbody>
                            <tr>
                                <td class="fw-medium">Tasks Title</td>
                                <td class="text-break">{{$task->name}}</td>
                            </tr>


                            <tr>
                                <td class="fw-medium">Status</td>
                                <td>
                                    <span class="badge badge-soft-{{\App\Helper\Helper::getStatusColor($task->status)}}">{{\App\Helper\Helper::getStatus(2, $task->status)}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-medium">Due Date</td>
                                <td>{{\App\Helper\Helper::letter_date($task->end_date)}}</td>
                            </tr>
                            </tbody>
                        </table><!--end table-->
                    </div>
                </div>
            </div><!--end card-->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <h6 class="card-title mb-0 flex-grow-1">Assigned To({{$task->assignUsers->count()}})</h6>
                        @if(\App\Helper\Helper::otherSubTaskEditable(auth()->user(), $task))
                        <div class="flex-shrink-0">
                            <button data-bs-toggle="modal" data-bs-target="#inviteMembersModal" onclick="open_invite_modal()" type="button" class="btn btn-soft-danger btn-sm"><i
                                    class="ri-share-line me-1 align-bottom"></i> Assign Member</button>
                        </div>
                        @endif
                    </div>
                    <ul class="list-unstyled vstack gap-3 mb-0">
                        @foreach($task->assignUsers as $item)
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        {!! \App\Helper\Helper::avatar($item->avatar, $item->name, 'avatar-xs', 11, auth() && auth()->user()->id === $item->id) !!}
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-1"><a href="#">{{$item->name}}</a></h6>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="dropdown">
                                            <button class="btn btn-icon btn-sm fs-16 text-muted dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#modal_delete_leader" class="dropdown-item" onclick="delete_deader({{$item->id}})"><i class="ri-delete-bin-5-fill text-muted me-2 align-bottom"></i>Delete</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div><!--end card-->
        </div><!---end col-->
        <div class="col-xxl-9">
            <div class="card">
                <div class="card-header align-items-center d-flex justify-content-between">
                    <h4 class="card-title mb-0 text-uppercase">Description</h4>
                    @if(\App\Helper\Helper::otherSubTaskEditable(auth()->user(), $task))
                    <button data-bs-toggle="modal" data-bs-target="#edit_modal" class="btn btn-success">Edit</button>
                    @endif
                </div>
                <div class="card-body">
                    <div class="ql-editor">
                        {!! $task->description !!}
                    </div>
                </div>
            </div><!--end card-->
            <div class="card">
                <div class="card-header align-items-center d-flex border-bottom-dashed">

                    <h4 class="card-title mb-0 flex-grow-1">Attachments File ({{$task->attachments->count()}})</h4>
                    @if(\App\Helper\Helper::otherSubTaskEditable(auth()->user(), $task))
                    <div class="flex-shrink-0">
                        <button data-bs-toggle="modal" data-bs-target="#modal_uplaod" onclick="open_modal_uplaod()" type="button" class="btn btn-soft-info btn-sm"><i
                                class="ri-upload-2-fill me-1 align-bottom"></i> Upload</button>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <table class="table table-borderless align-middle mb-0">
                        <thead class="table-light text-muted">
                        <tr>
                            <th scope="col">File Name</th>
                            <th scope="col">Size</th>
                            <th scope="col">Upload Date</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($task->attachments as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm">
                                            <div class="avatar-title bg-soft-primary text-primary rounded fs-20">
                                                <i class="ri-file-zip-fill"></i>
                                            </div>
                                        </div>
                                        <div class="ms-3 flex-grow-1">
                                            <h6 class="fs-15 mb-0"><a href="javascript:void(0)">{{$item->real_name}}</a></h6>
                                        </div>
                                    </div>
                                </td>
                                <td>2.22 MB</td>
                                <td>{{\App\Helper\Helper::letter_date($item->created_at)}}</td>
                                <td>
                                    <div class="dropdown">
                                        <a href="javascript:void(0);" class="btn btn-light btn-icon" id="dropdownMenuLink1{{$item->id}}" data-bs-toggle="dropdown" aria-expanded="true">
                                            <i class="ri-equalizer-fill"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink1{{$item->id}}" data-popper-placement="bottom-end" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 23px);">
                                            <li><a class="dropdown-item" download href="{{url('public/attaches/'.$item->path_name)}}"><i class="ri-download-2-fill me-2 align-middle text-muted"></i>Download</a></li>
                                            @if(\App\Helper\Helper::otherSubTaskEditable(auth()->user(), $task))
                                            <li class="dropdown-divider"></li>
                                            <li><button type="button" data-bs-toggle="modal" data-bs-target="#modal_delete_attachment" class="dropdown-item" onclick="delete_attachment({{$item->id}})"><i class="ri-delete-bin-5-line me-2 align-middle text-muted"></i>Delete</button></li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table><!--end table-->
                </div>
            </div><!--end card-->
        </div><!--end col-->
    </div><!--end row-->



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
                    <form id="form" method="post" action="{{url('tasks/sub_invite/')}}">
                        <input name="id" type="hidden" value="{{$task->id}}">
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
{{--                            @foreach($members as $item)--}}
{{--                                <div class="d-flex align-items-center member_item">--}}
{{--                                    <div class="avatar-xs flex-shrink-0 me-3">--}}
{{--                                        {!! \App\Helper\Helper::avatar($item->avatar, $item->name, "avatar-xs") !!}--}}
{{--                                    </div>--}}
{{--                                    <div class="flex-grow-1">--}}
{{--                                        <h5 class="fs-13 mb-0"><a href="#" class="text-body d-block name">{{$item->name}}</a>--}}
{{--                                        </h5>--}}
{{--                                    </div>--}}
{{--                                    <div class="flex-shrink-0">--}}
{{--                                        <button type="button" class="btn btn-light btn-sm" onclick="add_user({{json_encode($item)}})">Add</button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
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
                            <p class="text-muted mx-4 mb-0">Are you Sure You want to Delete this member ?</p>
                        </div>
                    </div>
                    <div class="hstack gap-2 justify-content-center mt-3">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                        <form method="post" action="{{url('tasks/sub_delete_member/')}}">
                            {{csrf_field()}}
                            <input type="hidden" name="member_id" value="">
                            <input type="hidden" name="task_id" value="{{$task->id}}">
                            <button type="submit" href="javascript:void(0);" class="btn btn-danger">Yes, Delete It!</button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



    <div class="modal fade zoomIn" id="edit_modal" tabindex="-1" aria-labelledby="createProjectModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-soft-info">
                    <h5 class="modal-title" id="createProjectModelLabel">Sub Task Description</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                <form id="edit_task" action="{{url('tasks/sub_edit')}}" method="post" class="needs-validation" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" value="{{$task->id}}" name="id">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <div class="snow-editor" id="ckeditor-classic" style="height: 300px">{!! $task->description !!}</div>
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 flex-wrap">
                            <button type="button" class="btn btn-light" id="close-modal"
                                    data-bs-dismiss="modal">Close
                            </button>
                            <button type="button" class="btn btn-success" id="edit-btn">Edit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modal_uplaod" tabindex="-1" aria-labelledby=""
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-3 ps-4 bg-soft-success">
                    <h5 class="modal-title" id="inviteMembersModalLabel">Upload</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form" method="post" action="{{url('tasks/sub_upload_file/')}}" enctype="multipart/form-data">
                    <div class="modal-body p-4">
                        <input name="id" type="hidden" value="{{$task->id}}">
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
                        <form method="post" action="{{url('tasks/sub_delete_attachment/')}}">
                            {{csrf_field()}}
                            <input type="hidden" name="attachment_id" value="">
                            <input type="hidden" name="path_name" value="">
                            <input type="hidden" name="task_id" value="{{$task->id}}">
                            <button type="submit" href="javascript:void(0);" class="btn btn-danger">Yes, Delete It!</button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/quill/quill.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection

@section('script-bottom')
<script>
    let candidate_user_list = @json($members);
    let user_list = @json($task->assignUsers);

    { // invite leader
        function add_user(obj, i){
            var user = candidate_user_list[i];
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


    var myEditor;
    {// description edit
        $('#edit-btn').click(function () {
            var description = myEditor.container.firstChild.innerHTML;
            if (description === "<p><br></p>"){
                notification("Please input description of the project.");
                return;
            }
            var html_description = $("<input>")
                .attr("type", "hidden")
                .attr("name", "description").val(description);
            $('#edit_task').append(html_description);

            $('#edit_task').submit();
        });
    }

    { // file upload
        let modal_uplaod = $("#modal_uplaod");
        function open_modal_uplaod(){
            modal_uplaod.modal("show");
        }
    }

    { // delete attachment
        var modal_delete_attachment = $('#modal_delete_attachment');
        function delete_attachment(id) {
            $('input[name="attachment_id"]').val(id);
            modal_delete_attachment.modal("show");
        }
    }

    {// change status
        $('#change_status').change(function () {
            $('#form_status').submit();
        });
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
