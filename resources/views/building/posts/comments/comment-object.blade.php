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
$hFunction = new Hfunction();
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
$commentId = $dataBuildingPostsComment->commentId();
$commentUserId = $dataBuildingPostsComment->userId();
$postId = $dataBuildingPostsComment->postId();
$dateAdded = $dataBuildingPostsComment->createdAt();

$date = new DateTime($dateAdded);
$dateComment = $date->format('m-d-Y H:i:s');

# user comment
$dataUserComment = $dataBuildingPostsComment->user;
$userCommentId = $dataUserComment->userId();

$userCommentAvatarPath = $dataUserComment->pathSmallAvatar($userCommentId, true);
$userCommentAlias = $dataUserComment->alias();

# building owner
$userBuildingId = $dataUserBuilding->userId();

?>
<div class="tf_building_posts_comment_object tf-padding-top-5 tf-padding-bot-5 tf-padding-rig-none col-xs-12 col-sm-12 col-sm-12 col-lg-12"
     data-date="{!! $dateAdded !!}" data-comment="{!! $commentId !!}">
    <div class="media tf-position-rel tf-padding-rig-none">

        {{--avatar --}}
        <a class="pull-left" href="{!! route('tf.user.home', $userCommentAlias) !!}" target="_blank">
            <img class="media-object tf-border-radius-4 tf-icon-30" alt="keyword-seo"
                 style="border: 1px solid #c2c2c2;" src="{!! $userCommentAvatarPath !!}">
        </a>

        {{--content--}}
        <div class="media-body tf-padding-none">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-sm-12 col-lg-12">
                    <a class="tf-link-bold" href="{!! route('tf.user.home', $userCommentAlias) !!}" target="_blank">
                        {!! $dataUserComment->fullName() !!}
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="tf_building_post_object_content col-xs-12 col-sm-12 col-sm-12 col-lg-12">
                    {!! $hFunction->identifyLink($dataBuildingPostsComment->content()) !!}
                    <br/>
                    <em class="tf-color-grey">{!! $dateAdded !!}</em>
                </div>
            </div>
        </div>

        {{--menu --}}
        @if($loginStatus)
            @if($userLoginId == $userCommentId || $userLoginId == $userBuildingId )
                <div class="tf_posts_comment_menu_wrap tf-position-abs tf-display-none" style="top: 0; right: 0;">
                    <i class="dropdown-toggle tf-link-grey-bold tf-font-size-14" data-toggle="dropdown">...</i>
                    <ul class="dropdown-menu dropdown-menu-right tf_posts_comment_menu tf-padding-none tf-font-size-12">
                        @if($userLoginId == $userCommentId)
                            <li>
                                <a class="tf_edit tf-bg-hover"
                                   data-href="{!! route('tf.building.posts.comment.edit.get') !!}">
                                    {!! trans('frontend_building.post_comment_menu_edit') !!}
                                </a>
                            </li>
                        @endif
                        <li class="">
                            <a class="tf_delete tf-bg-hover"
                               data-href="{!! route('tf.building.posts.comment.delete') !!}">
                                {!! trans('frontend_building.post_comment_menu_delete') !!}
                            </a>
                        </li>
                    </ul>
                </div>
            @endif
        @endif
    </div>
</div>
