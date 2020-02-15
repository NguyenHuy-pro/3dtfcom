<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/5/2016
 * Time: 1:37 PM
 */
/*
 * $modelUser
 * $dataUserPostComment
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

# comment info
$commentId = $dataUserPostComment->commentId();
$commentUserId = $dataUserPostComment->userId();
$postId = $dataUserPostComment->postId();
$addDate = $dataUserPostComment->createdAt();

$date = new DateTime($addDate);
$dateComment = $date->format('m-d-Y H:i:s');

# user comment
$dataUserComment = $dataUserPostComment->user;
$userCommentId = $dataUserComment->userId();

$userCommentAvatarPath = $dataUserComment->pathSmallAvatar($userCommentId, true);
$userCommentAlias = $dataUserComment->alias();

# user wall
$userWallId = $dataUserPostComment->userPost->userWallId();

?>
<div class="tf_user_activity_post_comment_object tf-padding-top-5 tf-padding-bot-5 tf-padding-rig-none col-xs-12 col-sm-12 col-md-12 col-lg-12"
     data-date="{!! $addDate !!}" data-comment="{!! $commentId !!}">
    <div class="media tf-position-rel tf-padding-rig-none" >

        {{--avatar --}}
        <a class="pull-left" href="{!! route('tf.user.home', $userCommentAlias) !!}" target="_blank" >
            <img class="media-object tf-border-radius-4 tf-icon-30" alt="keyword-seo"
                 style="border: 1px solid #c2c2c2;" src="{!! $userCommentAvatarPath !!}">
        </a>

        {{--content--}}
        <div class="media-body tf-padding-none">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <a href="{!! route('tf.user.home', $userCommentAlias) !!}" target="_blank">
                        {!! $dataUserComment->fullName() !!}
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="tf_comment_content col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    {!! $dataUserPostComment->content() !!}
                    <br/>
                    <em class="tf-color-grey">{!! $addDate !!}</em>
                </div>
            </div>
        </div>

        {{--menu --}}
        @if($loginStatus)
            @if($userLoginId == $userCommentId || $userLoginId == $userWallId )
                <div class="tf_post_comment_menu_wrap tf-position-abs tf-display-none " style="top: 0; right: 0;">
                    <i class="dropdown-toggle tf-link-grey-bold tf-font-size-14" data-toggle="dropdown">...</i>
                    <ul class="dropdown-menu dropdown-menu-right tf_post_comment_menu tf-padding-none tf-font-size-12">
                        @if($userLoginId == $userCommentId)
                            <li>
                                <a class="tf_edit tf-bg-hover" data-href="{!! route('tf.user.activity.post.comment.edit.get') !!}">
                                    Edit
                                </a>
                            </li>
                        @endif
                        <li class="">
                            <a class="tf_delete tf-bg-hover" data-href="{!! route('tf.user.activity.post.comment.delete') !!}">
                                {!! trans('frontend_building.post_comment_menu_delete') !!}
                            </a>
                        </li>
                    </ul>
                </div>
            @endif
        @endif
    </div>
</div>

