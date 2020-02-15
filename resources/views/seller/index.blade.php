<?php
/*
 * modelAbout
 */
#about info
$dataAbout = $modelAbout->defaultInfo();
if (count($dataAbout) > 0) {
    $metaKeyword = $dataAbout->metaKeyword();
    $metaDescription = $dataAbout->metaDescription();
    $systemLogo = $dataAbout->pathLogoSystem();
} else {
    $metaKeyword = null;
    $metaDescription = null;
    $systemLogo = null;
}

?>
@extends('master')

{{--develop seo--}}
@section('metaKeyword'){!! $metaKeyword !!}@endsection

@section('metaDescription'){!! $metaDescription !!}@endsection

@section('titlePage')
    {!! trans('frontend_seller.title_page') !!}
@endsection

{{--shortcut Page--}}
@section('shortcutPage')
    @if(!empty($systemLogo))
        <link rel="shortcut icon" href="{!! $systemLogo !!}"/>
    @endif
@endsection

{{--css--}}
@section('tf_master_page_css')
    <link href="{{ url('public/seller/css/seller.css')}}" rel="stylesheet">
@endsection

{{--js--}}
@section('tf_master_page_js_header')
    <script src="{{ url('public/seller/js/seller.js')}}"></script>
@endsection

{{--========== ========= header content ========= ========== --}}
{{--left header--}}
@section('tf_main_header_Left')
    {{--search--}}
    @include('components.search.search-form')
@endsection

{{--========== ========= main content ========= ========== --}}
@section('tf_main_content')
    <div class="tf-seller-wrap col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="row">
            <div class="tf-margin-bot-50 col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
                {{--wrap content--}}
                <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1"
                     style="border: 1px solid #c2c2c2;">
                    {{--point logo--}}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            @include('seller.components.title.title')
                        </div>
                    </div>

                    {{--menu--}}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            @yield('seller_menu')
                        </div>
                    </div>

                    {{--content--}}
                    <div class="row tf-bg-white">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="min-height: 1000px;">
                            @yield('seller_content')
                        </div>
                    </div>
                </div>

                {{-- extend - develop later --}}
                <div class="hidden-xs hidden-sm hidden-md hidden-lg">

                </div>
            </div>
        </div>
    </div>
@endsection

{{--=========== ========== Footer map =========== =========--}}
@section('tf_main_footer')
    @include('components.footer.footer')
@endsection