@extends('layouts.master')
@section('title') @lang('translation.projects') @endsection
@section("css_bottom")
    <link href="{{asset('assets/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css')}}" rel="stylesheet"/>
@endsection
@section('content')
    @component('components.main_breadcrumb')
        @slot('title') Kpi Charts @endslot
        @slot('li_1') Admin panel @endslot
    @endcomponent
    @include('layouts.errors')
    @include('layouts.flash-message')
    <div id="kpi_chart_container">
{{--        <div class="col-xs-12 col-md-4 col-xl-4">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h4 class="card-title mb-0">Simple Donut Chart</h4>--}}
{{--                </div><!-- end card header -->--}}

{{--                <div class="card-body">--}}
{{--                    <div id="simple_dount_chart"--}}
{{--                         data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]'--}}
{{--                         class="apex-charts" dir="ltr"></div>--}}
{{--                </div><!-- end card-body -->--}}
{{--            </div><!-- end card -->--}}
{{--        </div>--}}
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
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
            url: "{{url('kpi/update_kpi_chart')}}",
            method: "post",
            data: {
                _token: '{{csrf_token()}}',
            },
            success: function (response) {
                $('#kpi_chart_container').empty();
                $('#kpi_chart_container').html(response);

            },
            error: function (response){

            },
            failure: function (response){

            }
        }).done(function () {
            setTimeout(function(){
                $("#overlay").fadeOut(50);
            },500);
        });
    });
</script>
@endsection
