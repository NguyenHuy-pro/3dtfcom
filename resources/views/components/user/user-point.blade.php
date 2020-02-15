<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 3/10/2017
 * Time: 2:51 PM
 *
 * $modelUser
 */
$mobile = new Mobile_Detect();
$dataUserLogin = $modelUser->loginUserInfo();
$loginUserId = $dataUserLogin->userId();
?>
{{--point--}}
<div class="tf-main-header-wrap-icon pull-right ">
    <a class="tf-link-action tf-link-red" href="{!! route('tf.point.direct.get') !!}"
       title="{!! trans('frontend.header_point_title') !!}">
        <img class="@if($mobile->isMobile()) tf-icon-20 @else tf-icon-40 @endif" alt="point"
             src="{!! asset('public\main\icons\addPoint.png') !!}">
        <span id="headerPoint">
            {!! $dataUserLogin->point($loginUserId) !!}
        </span>
    </a>
</div>

