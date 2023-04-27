<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light" data-sidebar="dark"
    data-sidebar-size="lg" data-sidebar-image="none">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') </title>
    <link rel="canonical" href="https://mchd-manager.com" />
    <meta property="og:site_name" content="Maternity and Children Hospital Projects Management">
    <meta property="og:title" content="Maternity and Children Hospital Projects Management">
    <meta property="og:description" content="Maternity and Children Hospital Projects Management">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en">
    <meta property="og:url" content="https://mchd-manager.com/">
    <meta property="og:image" content="{{ asset('assets/images/logo-sm.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Maternity and Children Hospital Projects Management">

    <meta name="format-detection" content="telephone=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Maternity and Children Hospital Projects Management" name="description" />
    <meta content="Damman" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}">
    <style>
        #back-to-top {
            position: fixed;
            bottom: 30px !important;
            right: 28px;
            transition: all 0.5s ease;
            display: none;
            z-index: 1000;
        }

        .comments {
            max-height: 300px;
            overflow-y: auto;
        }

        .comments .comment {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            margin-bottom: 1rem;
            margin-right: 1rem;
            border: 1px solid var(--vz-primary);
            border-radius: 1rem;
            padding: 10px;
        }
    </style>
    @include('layouts.head-css')
</head>

@section('body')
    @include('layouts.body')
@show
<!-- Begin page -->
<div id="layout-wrapper">
    @include('layouts.topbar')
    @include('layouts.sidebar')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        {{--            @include('layouts.footer') --}}
    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->

<div class="position-fixed top-0 end-0 p-3" style="z-index: 1100000000">
    <div id="myToast" class="toast align-items-center text-white bg-danger border-0" role="alert"
        aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">

            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</div>

<div class="position-fixed top-0 end-0 p-3" style="z-index: 1100000000">
    <div id="toast_success" class="toast align-items-center text-white bg-success border-0" role="alert"
        aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">

            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</div>


@include('layouts.customizer')

<!-- JAVASCRIPT -->
@include('layouts.vendor-scripts')
</body>

</html>
