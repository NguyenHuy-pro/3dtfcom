<?php
/*
 * $modelUser
 */

$modelMobile = new Mobile_Detect();

$dataUserLogin = $modelUser->loginUserInfo();
$loginStatus = false;
if (count($dataUserLogin) > 0) {
    $loginStatus = true;
    $dataUserStatistic = $dataUserLogin->statisticInfo();
}

?>
<div id="tf_main_header" class="row tf-main-header">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        {{-- ========= ========= left of header =========== ========= --}}
        <div id="tf_main_header_left" class="tf_main_header_left tf-main-header-left pull-left">
            {{--logo of system--}}
            <div class="tf-main-header-wrap-icon pull-left ">
                <a class="tf-link-action" href="{!! URL::route('tf.home.center') !!}">
                    <img class="tf-logo" title="3dtf.com" alt="logo"
                         src="{!! asset('public/main/icons/3dlogoWhite.png') !!}"/>
                </a>
            </div>

            {{--left header content of current page--}}
            @yield('tf_main_header_Left')
        </div>

        @if(!$modelMobile->isMobile())
            {{-- ========== ========== center of header ============ ========== --}}
            <div id="tf_main_header_center"
                 class="tf_main_header_center tf-main-header-center pull-left hidden-xs hidden-sm">
                @yield('tf_main_header_center')
            </div>
        @endif

        {{-- ========== ========== right of header ========== ==========--}}
        <div id="tf_main_header_right" class="tf_main_header_right tf-main-header-right pull-right">
            {{--extend menu--}}
            @include('components.header.extend')

            @if($loginStatus)
                {{--point--}}
                @include('components.user.user-point', ['modelUser' => $modelUser])

                {{--info of user--}}
                @include('components.user.user-info', ['modelUser' => $modelUser])

                {{-- Owned tool--}}
                @include('components.owned.owned')

                {{-- notify about friend --}}
                @include('components.notify.friend.notify', ['dataUserStatistic'=>$dataUserStatistic])

                {{-- notify about action--}}
                @include('components.notify.activity.notify', ['dataUserStatistic'=>$dataUserStatistic])

                {{-- show menu when small screen--}}
                {{--@include('components.user.small-menu', ['modelUser' => $modelUser])--}}

            @else
                {{--register--}}
                <div class="tf-main-header-wrap-icon  pull-right">
                    <a class="tf-link-action" href="{!! route('tf.register.get') !!}">
                        {!! trans('frontend.header_register') !!}
                    </a>
                </div>

                {{--form login--}}
                <div class="tf-main-header-wrap-icon pull-right">
                    <a class="tf_main_login_get tf-link-action" data-href="{!! route('tf.login.get') !!}">
                        {!! trans('frontend.header_login') !!}
                    </a>
                </div>
            @endif

            {{--right of header content--}}
            @yield('tf_main_header_right')
        </div>
    </div>
</div>