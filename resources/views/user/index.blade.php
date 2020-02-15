<?php

/*
 * modelAbout
 * $modelUser
 * $dataUser
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
    $systemLogo = $dataAbout->pathLogoSystem();

} else {
    $metaKeyword = null;
    $metaDescription = null;
    $systemLogo = null;
}

#user info
$userName = $dataUser->fullName();
$alias = $dataUser->alias();

#banner info
$dataImageBanner = $modelUser->imageBannerInfoUsing($dataUser->userId());
if (count($dataImageBanner) > 0) {
    $shareImage = $dataImageBanner->pathFullImage();
} else {
    $shareImage = $modelUser->pathDefaultBannerImage();
}
?>

@extends('master')
{{--develop seo--}}
@section('metaKeyword'){!! $metaKeyword !!}@endsection
@section('metaDescription'){!! $metaDescription !!}@endsection

@section('extendMetaPage')
    {{--share on fb--}}
    <meta property="fb:app_id" content="1687170274919207"/>
    <meta property="og:type" content="Website"/>
    <meta property="og:title" content="{!! $userName !!}"/>
    <meta property="og:site_name" content="3dtf.com"/>
    <meta property="og:url" content="{!! route('tf.user.home', $alias) !!}"/>
    <meta property="og:description" content=""/>
    <meta property="og:image" content="{!! $shareImage !!}"/>
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">

    {{--share on G+--}}
    <meta itemprop="name" content="{!! $userName !!}"/>
    <meta itemprop="description" content=""/>
    <meta itemprop="url" content="{!! route('tf.user.home', $alias) !!}"/>
    <meta itemprop="image" content="{!! $shareImage !!}"/>
@endsection

{{--title--}}
@section('titlePage')
    {!! $dataUser->fullName() !!}
@endsection

@section('shortcutPage')
    @if(!empty($systemLogo))
        <link rel="shortcut icon" href="{!! $systemLogo !!}"/>
    @endif
@endsection

{{--css--}}
@section('tf_master_page_css')
    <link href="{{ url('public/user/css/user.css')}}" rel="stylesheet">
@endsection

{{--js--}}
@section('tf_master_page_js_header')
    <script src="{{ url('public/user/js/user.js')}}"></script>
    {{-- insert js --}}
    @yield('tf_user_page_js_header')
@endsection

{{--========== ========= content header ========= ========== --}}
{{--left header--}}
@section('tf_main_header_Left')
    {{--search--}}
    @include('components.search.search-form')
@endsection

@section('tf_main_content')
    <div id="tf_user_wrapper" class="tf-user-wrapper col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
            <div class="row tf-padding-bot-50">
                {{--content--}}
                <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1 ">
                    {{-- user title--}}
                    @include('user.components.title.title-content',
                        [
                            'modelUser'=>$modelUser,
                            'dataUser'=>$dataUser,
                            'dataImageBanner' => $dataImageBanner
                        ])


                    {{--main content--}}
                    <div class="row">
                        {{--left content--}}
                        <div class="tf-padding-none hidden-12 col-sm-4 col-md-3 col-lg-3">
                            {{--love page--}}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                    @include('user.components.love.love',
                                        [
                                            'modelUser' => $modelUser,
                                            'dataUser'=>$dataUser
                                        ])
                                </div>
                            </div>

                            {{--left menu--}}
                            @include('user.components.menu.menu',
                                [
                                    'modelUser' => $modelUser,
                                    'dataUser'=>$dataUser,
                                    'dataAccess' => $dataAccess
                                ])
                        </div>

                        {{--right content--}}
                        <div class="tf-user-content tf-border-radius-5 col-xs-12 col-sm-8 col-md-9 col-lg-9 ">
                            @yield('tf_user_content')
                        </div>
                    </div>

                </div>

                {{-- develop ads --}}
                <div class="tf-user-ads text-center hidden-xs hidden-sm hidden-md hidden-lg ">

                </div>
            </div>
        </div>

        {{--on top--}}
        <div class="tf_user_on_top tf-user-on-top">
            <a class="tf_action tf-link-hover-white tf-bg-hover tf-padding-10 ">
                <i class="glyphicon glyphicon-arrow-up"></i>
            </a>
        </div>
    </div>
@endsection

{{--=========== ========== Footer map =========== =========--}}
@section('tf_main_footer')
    @include('components.footer.footer')
@endsection