@extends('layouts.master')
@section('title') @lang('translation.projects') @endsection
@section("css_bottom")
{{--    <link href="{{asset('assets/libs/gijgo/gijgo.min.css')}}" rel="stylesheet" type="text/css" />--}}
<link rel="stylesheet" href="{{asset('assets/libs/editable-table/editable-table.css')}}">
<link href="{{asset('assets/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css')}}" rel="stylesheet"/>
@endsection
@section('content')
    @component('components.main_breadcrumb')
        @slot('title') Kpi Data @endslot
        @slot('li_1') Admin panel @endslot
    @endcomponent
    @include('layouts.errors')
    @include('layouts.flash-message')
    <div class="row">
        <div class="col-xs-12" id="kpi_data_container"></div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/libs/editable-table/babel-external-helpers.js')}}"></script>
{{--    <script src="{{asset('assets/libs/gijgo/gijgo.min.js')}}" type="text/javascript"></script>--}}
    <script src="{{asset('assets/libs/editable-table/mindmup-editabletable.js')}}"></script>
    <script src="{{asset('assets/libs/editable-table/Plugin.js')}}"></script>
    <script src="{{asset('assets/libs/editable-table/editable-table.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection

@section('script-bottom')
    <script>
        $(document).ready(function () {
            $(document).ajaxSend(function() {
                $("#overlay").fadeIn(50);
            });
            $.ajax({
                url: "{{url('kpi/get_kpi_data')}}",
                method: "post",
                data: {
                    _token: '{{csrf_token()}}',
                },
                success: function (response) {
                    $('#kpi_data_container').empty();
                    $('#kpi_data_container').html(response);

                },
                error: function (response){

                },
                failure: function (response){

                }
            }).done(function () {
                setTimeout(function(){
                    $("#overlay").fadeOut(200);
                },500);
            });
        });
    </script>
@endsection
