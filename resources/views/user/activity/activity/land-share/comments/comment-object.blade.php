<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/5/2016
 * Time: 1:37 PM
 */
/*
 * $modelUser
 * $dataBuildingPostsComment
 * $dataUserBuilding
 *
 *
 */

# info of user login
$dataUserLogin = $modelUser->loginUserInfo();
if (count($dataUserLogin) > 0) {
    $loginStatus = true;
    $userLoginId = $dataUserLogin->userId();
} else {
    $loginStatus = false;
    $userLoginId = null;
}

?>
<div class="tf_user_activity_posts_comment_object tf-padding-top-5 tf-padding-bot-5 tf-padding-rig-none col-xs-12 col-sm-12 col-md-12 col-lg-12"
     data-date="" data-comment="1">
    <div class="media tf-position-rel tf-padding-rig-none" >
        {{--avatar --}}
        <a class="pull-left" href="#" target="_blank" >
            <img class="media-object tf-border-radius-4 tf-icon-30" alt="keyword-seo"
                 style="border: 1px solid #c2c2c2;" src="{!! asset('public\main\icons\icon_people_1.jpeg') !!}">
        </a>

        {{--content--}}
        <div class="media-body tf-padding-none">
            <div class="tf-padding-none col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <a href="#" target="_blank">
                    User name
                </a>
            </div>
            <div class="tf_user_activity_post_object_content tf-padding-none col-xs-12 col-sm-12 col-md-12 col-lg-12">
                Comment content
                <br/>
                <em class="tf-color-grey">01/03/2017</em>
            </div>
        </div>

        {{--menu --}}
        <div class="tf_posts_comment_menu_wrap tf-position-abs" style="top: 0; right: 0;">
            <i class="fa fa-chevron-down dropdown-toggle tf-link-grey tf-font-size-14" data-toggle="dropdown"></i>
            <ul class="tf_posts_comment_menu dropdown-menu dropdown-menu-right tf-padding-none tf-font-size-12">
                <li>
                    <a class="tf_edit tf-bg-hover" data-href="#">
                        {!! trans('frontend_building.post_comment_menu_edit') !!}
                    </a>
                </li>
                <li class="">
                    <a class="tf_delete tf-bg-hover" data-href="#">
                        {!! trans('frontend_building.post_comment_menu_delete') !!}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
