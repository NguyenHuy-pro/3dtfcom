<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/7/2016
 * Time: 2:59 PM
 *
 *
 * modelAbout
 * modelUser
 * dataHelpObjectAccess
 * dataHelpActionAccess
 *
 *
 */

$dataUserLogin = $modelUser->loginUserInfo();
$loginStatus = false;
if (!empty($dataUserLogin)) {
    $loginStatus = true;
}

#about info
$dataAbout = $modelAbout->defaultInfo();
if (count($dataAbout) > 0) {
    $metaKeyword = $dataAbout->metaKeyword();
    $metaDescription = $dataAbout->metaDescription();

} else {
    $metaKeyword = null;
    $metaDescription = null;
}
?>
@extends('master')

{{--develop seo--}}
@section('metaKeyword'){!! $metaKeyword !!}@endsection
@section('metaDescription'){!! $metaDescription !!}@endsection

@section('titlePage')
    help
@endsection
@section('shortcutPage')
    <link rel="shortcut icon" href="{!! asset('public/main/icons/3dlogo128.png') !!}"/>
@endsection

{{--css--}}
@section('tf_master_page_css')
    <link href="{{ url('public/help/css/help.css')}}" rel="stylesheet">
@endsection

{{--js--}}
@section('tf_master_page_js_header')
    <script src="{{ url('public/help/js/help.js')}}"></script>
@endsection

{{--========== ========= header content ========= ========== --}}
{{--left header--}}
@section('tf_main_header_Left')
    {{--search--}}
    @include('components.search.search-form')
@endsection

{{--========== ========= main content ========= ========== --}}
@section('tf_main_content')
    <div id="tf_help_wrap" class="container-fluid tf-help-wrap">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 tf-help" style="padding-bottom: 100px;">
                <div class="row">
                    {{-- title--}}
                    <div class="col-xs-12 col-md-12 text-center ">
                        @include('help.components.title.title')
                    </div>

                    {{--breadcrumb--}}
                    <div class=" col-xs-12 col-md-12 col-lg-12">
                        @include('help.components.breadcrumb.breadcrumb')
                    </div>

                    {{--content--}}
                    <div class="col-xs-12 col-md-12 tf-padding-top-20">
                        <div class="row">
                            {{-- left content--}}
                            <div class="col-xs-4 col-sm-4 col-md-3 tf-padding-none">
                                @include('help.components.menu.menu')
                            </div>

                            {{-- right content--}}
                            <div class="col-xs-8 col-sm-8 col-md-9 tf-padding-none">
                                @include('help.object.object')
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{--on top--}}
        <div class="tf_help_on_top tf-help-on-top">
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