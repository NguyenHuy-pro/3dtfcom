<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 3/10/2017
 * Time: 2:46 PM
 *
 * $modelUser
 *
 */
$modelMobile = new Mobile_Detect();

$dataUserLogin = $modelUser->loginUserInfo();
$loginUserId = $dataUserLogin->userId();
$pathAvatar = $dataUserLogin->pathSmallAvatar($loginUserId, true);
?>
{{--info of user--}}
@if(!$modelMobile->isMobile())
    <div class="tf-main-header-wrap-icon pull-right">
        <a class="tf-link-action" href="{!! route('tf.user.home') !!}" target="_blank"
           title="{!! $dataUserLogin->fullName()  !!}">
            {!! $dataUserLogin->lastName() !!}
        </a>
    </div>
@endif

<div class="tf-main-header-wrap-icon pull-right">
    <a class="tf_main_header_user_avatar tf-link-action dropdown-toggle " data-toggle="dropdown">
        <img class="tf-user-avatar " alt="{!! $dataUserLogin->alias() !!}" src="{!! $pathAvatar !!}">
    </a>

    <div class="dropdown-menu dropdown-menu-right tf-user-menu tf-box-shadow">
        @if($modelMobile->isMobile())
            <div class="list-group ">
                <a class="tf_owned_get list-group-item tf-bg-hover" data-href="{!! route('tf.owned.building.get') !!}"
                   style="border-bottom: 2px solid #c2c2c2 !important;">
                    <label style="width: 20px;">
                        <i class="glyphicon  glyphicon-th-list tf-color-grey tf-font-bold tf-font-size-16 "></i>
                    </label>&nbsp;
                    Property
                </a>

                <a class="tf_notify_get list-group-item tf-bg-hover" data-href="{!! route('tf.notify.action.get') !!}">
                    <label style="width: 20px;">
                        <i class="fa fa-globe tf-color-grey tf-font-bold tf-font-size-16 "></i>
                    </label>&nbsp;
                    Activity
                </a>
                <a class="tf_notify_get list-group-item tf-bg-hover" data-href="{!! route('tf.notify.friend.get') !!}">
                    <label style="width: 20px;">
                        <i class="fa fa-users tf-color-grey tf-font-bold tf-font-size-16 "></i>
                    </label>&nbsp;
                    Friend
                </a>

            </div>
        @endif
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <a class="btn btn-default tf-bg-hover" href="{!! route('tf.user.home') !!}">
                {!! trans('frontend.header_user_home') !!}
            </a>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <a class="btn btn-default tf-bg-hover" href="{!! route('tf.logout.get') !!}">
                {!! trans('frontend.header_user_exit') !!}
            </a>
        </div>
    </div>
</div>
