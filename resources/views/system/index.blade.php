<?php
/*
 * modelAbout
 * modelUser
 * dataSystemAccess
 */
?>
@extends('master')
@section('titlePage')
    3DTF
@endsection
@section('shortcutPage')
    <link rel="shortcut icon" href="{!! asset('public/main/icons/3dlogo128.png') !!}" />
@endsection

{{--css--}}
@section('tf_master_page_css')
    <link href="{{ url('public/system/css/system.css')}}" rel="stylesheet">
@endsection

{{--js--}}
@section('tf_master_page_js_header')
    <script src="{{ url('public/system/js/system.js')}}"></script>
@endsection

{{--========== ========= header content ========= ========== --}}
{{--left header--}}
@section('tf_main_header_Left')
    {{--search--}}
    @include('components.search.search-form')
@endsection

{{--========== ========= main content ========= ========== --}}
@section('tf_main_content')
    <div id="tf_system_wrap" class="container-fluid tf-system-wrap">
        <div class="row">
            {{--wrap content--}}
            <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 tf-bg-white" style="border: 1px solid #c2c2c2;" >
                <div class="row">
                    {{-- title--}}
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        @include('system.components.title.title')
                    </div>

                    {{--menu--}}
                    <div class="col-xs-12 col-sm-12 col-md-12 ">
                        @include('system.components.menu.menu', ['dataSystemAccess'=>$dataSystemAccess])
                    </div>

                    {{--content--}}
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 1000px;">
                        @yield('tf_system_content')
                    </div>
                </div>
            </div>
        </div>

        {{--on top--}}
        <div class="tf_system_on_top tf-system-on-top">
            <a class="tf_action tf-padding-10 tf-link-hover-white tf-bg-hover">
                <i class="glyphicon glyphicon-arrow-up"></i>
            </a>
        </div>
    </div>
@endsection

{{--=========== ========== Footer map =========== =========--}}
@section('tf_main_footer')
    @include('components.footer.footer')
@endsection