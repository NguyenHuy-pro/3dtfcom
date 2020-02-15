<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 3/10/2017
 * Time: 2:53 PM
 *
 * $modelUser
 *
 */

$dataUserLogin = $modelUser->loginUserInfo();
?>
{{-- show menu when small screen--}}
<div class="tf-main-header-wrap-icon tf-main-header-extend pull-right hidden-sm hidden-md hidden-lg tf-zindex-9">
    <span class="dropdown-toggle tf-cursor-pointer glyphicon glyphicon-align-justify tf-icon" data-toggle="dropdown"></span>

    <div class="dropdown-menu dropdown-menu-right list-group tf-box-shadow tf-margin-padding-none">
        <a class="tf_owned_get list-group-item tf-bg-hover" data-href="{!! route('tf.owned.building.get') !!}" style="border-bottom: 2px solid #c2c2c2 !important;">
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
</div>
