<?php
/*
 * modelAbout
 */
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
    Point
@endsection

@section('shortcutPage')
    <link rel="shortcut icon" href="{!! asset('public/main/icons/3dlogo128.png') !!}"/>
@endsection

{{--css--}}
@section('tf_master_page_css')
    <link href="{{ url('public/point/css/point.css')}}" rel="stylesheet">
@endsection

{{--js--}}
@section('tf_master_page_js_header')
    <script src="{{ url('public/point/js/point.js')}}"></script>
@endsection

{{--========== ========= header content ========= ========== --}}
{{--left header--}}
@section('tf_main_header_Left')
    {{--search--}}
    @include('components.search.search-form')
@endsection

{{--========== ========= main content ========= ========== --}}
@section('tf_main_content')
    <div class="tf-point-wrap tf-padding-none col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="tf-padding-bot-50 col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
            {{--wrap content--}}
            <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1" style="border: 1px solid #c2c2c2;">
                {{--point logo--}}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        @include('point.components.title.title')
                    </div>
                </div>

                {{--menu--}}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        @yield('point_menu')
                    </div>
                </div>

                {{--content--}}
                <div class="row tf-bg-white">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <a class="pull-right tf-link-bold" href="{!! route('tf.help','point-$/activities') !!}"
                           target="_blank">
                            {!! trans('frontend_point.label_get_free_point') !!}?
                        </a>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 tf-bg-white" style="min-height: 1000px;">
                        @yield('point_content')
                    </div>
                </div>
            </div>

            {{-- extend - develop later --}}
            <div class="hidden-xs hidden-sm hidden-md hidden-lg">
                @include('point.ads.ads')
            </div>
        </div>
    </div>
@endsection

{{--=========== ========== Footer map =========== =========--}}
@section('tf_main_footer')
    @include('components.footer.footer')
@endsection