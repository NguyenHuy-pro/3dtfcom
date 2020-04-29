<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/7/2016
 * Time: 2:59 PM
 *
 *
 * $modelUser
 *
 */
$mobile = new Mobile_Detect();
$mobileStatus = ($mobile->isMobile()) ? true : false;
?>
@extends('master')

{{--css--}}
@section('tf_master_page_css')
    <link href="{{ url('public/building/css/building.css')}}" rel="stylesheet">
    @yield('tf_building_css')
@endsection

{{--js--}}
@section('tf_master_page_js_header')
    <script src="{{ url('public/main/js/autosize/autosize.min.js')}}"></script>
    <script src="{{ url('public/building/js/building.js')}}"></script>
    {{--insert javascript--}}
    @yield('tf_building_header_js')
@endsection

{{--========== ========= content header ========= ========== --}}
{{--left header--}}
@section('tf_main_header_Left')
    {{--search--}}
    @include('components.search.search-form')
@endsection

@section('tf_main_content')
    <div id="tf_building_wrapper" class="container-fluid tf-building-wrapper">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1" style="padding-bottom: 80px;">
                {{--main content--}}
                <div class="tf-padding-top-10 col-xs-12 col-sm-12 col-md-7 col-lg-7 ">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            {{-- contain image and banner of building--}}
                            @yield('tf_building_title')

                            {{--menu--}}
                            @yield('tf_building_menu')
                        </div>
                    </div>

                    <div class="row tf-margin-top-15">
                        {{--content--}}
                        <div class="tf_building_content col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                            @yield('tf_building_content')
                        </div>

                        {{--ad--}}
                        @yield('tf_building_content_ads')

                        {{-- google adsense --}}
                        {{--<div class="tf-margin-top-5 col-xs-12 col-sm-12 col-md-12 col-lg-12"
                             align="center">
                            --}}{{--@include('components.google.adsense.codeShowAds728x90')--}}{{--
                            @include('components.google.adsense.codeAuto')
                        </div>--}}
                    </div>
                </div>

                {{-- extend --}}
                <div class="hidden-xs tf-padding-none hidden-sm col-md-5 col-lg-5" style="height: 100%;">
                    <table class="table" style="margin-top: 10px; height: 100%;">
                        <tr>
                            <td class="text-center" style="padding: 0 10px 0 15px;">
                                {{--news--}}
                                @yield('tf_building_news')
                            </td>
                            <td class="hidden-sm" style="padding-top: 0;">
                                {{-- google adsense --}}
                                {{--<div class=" tf-padding-none tf-margin-bot-5 col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                     style="width: 300px; text-align: center; background-color: grey;">
                                    @include('components.google.adsense.codeShowAds300x600')
                                </div>--}}
                                {{--ads--}}
                                <div class="tf-padding-none tf-margin-bot-5 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    @yield('tf_building_ads')
                                </div>
                            </td>

                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{--on top--}}
        <div class="tf_building_on_top tf-building-on-top">
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
