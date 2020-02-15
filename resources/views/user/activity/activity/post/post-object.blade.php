<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/13/2017
 * Time: 12:16 PM
 */
/*
 * modelUser
 * dataUserPost
 */

$hFunction = new Hfunction();
//post info
$postId = $dataUserPost->postId();
$userWall = $dataUserPost->userWall;
$userPost = $dataUserPost->userPost;
$userWallId = $dataUserPost->userWallId();
$userPostId = $dataUserPost->userPostId();
//user login info
$dataUserLogin = $modelUser->loginUserInfo();
if (count($dataUserLogin) > 0) {
    $loginStatus = true;
    $userLoginId = $dataUserLogin->userId();
    $ownerStatus = ($userWallId == $userLoginId) ? true : false;
} else {
    $loginStatus = false;
    $userLoginId = null;
    $ownerStatus = false;
}


?>
<div id="tf_user_activity_post_object_{!! $postId !!}" class="tf_user_activity_post_object row" data-post="{!! $postId !!}">
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg-none tf-border-none">
            <div class="row">
                <div class="col-xs-10 col-sm-8 col-md-8 col-lg-8">
                    <div class="media">
                        <a class="pull-left" href="{!! route('tf.user.activity.get',$userPost->alias()) !!}">
                            <img class="media-object tf-border tf-icon-50 tf-border-radius-5" alt="keyword-seo"
                                 src="{!! $userPost->pathSmallAvatar($userPostId, true) !!}">
                        </a>

                        <div class="media-body">
                            <p class="media-heading">
                                <a class="tf-link" href="{!! route('tf.user.activity.get',$userPost->alias()) !!}">
                                    {!! $userPost->fullName() !!}
                                </a>
                                @if($userPostId !== $userWallId)
                                    &nbsp;
                                    <i class="tf-color-grey tf-font-size-12 glyphicon glyphicon-play"></i>
                                    &nbsp;
                                    <a class="tf-link" href="{!! route('tf.user.activity.get', $userWall->alias()) !!}">
                                        {!! $userWall->fullName() !!}
                                    </a>
                                @endif
                            </p>
                            <span>{!! $userPost->createdAt() !!}</span>
                        </div>
                    </div>

                </div>

                {{--grant post--}}
                <div class="text-right col-xs-2 col-sm-4 col-md-4 col-lg-4">
                    @if($loginStatus)
                        <i class="fa fa-chevron-down dropdown-toggle tf-link-grey tf-font-size-14"
                           data-toggle="dropdown"></i>
                        <ul class="tf_posts_object_menu dropdown-menu dropdown-menu-right tf-padding-none tf-font-size-12">
                            {{--
                            <li>
                                <a class="tf_report tf-bg-hover"
                                   data-href="#">
                                    Report info
                                </a>
                            </li>
                            --}}

                            {{--edit info--}}
                            @if($userLoginId == $userPostId)
                                <li>
                                    <a class="tf_post_edit tf-bg-hover"
                                       data-href="{!! route('tf.user.activity.post.edit.get') !!}">
                                        Edit
                                    </a>
                                </li>
                            @endif

                            {{--delete --}}
                            @if($ownerStatus or $userLoginId == $userPostId)
                                <li>
                                    <a class="tf_post_delete tf-bg-hover"
                                       data-href="{!! route('tf.user.activity.post.delete') !!}">
                                        Delete
                                    </a>
                                </li>
                            @endif
                        </ul>
                    @endif
                </div>

            </div>
        </div>

        {{--text post--}}
        <div class="panel-body">
            {{--content--}}
            <div class="row">
                <div id="tf_user_activity_post_object_content_wrap_{!! $postId !!}"
                     class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    @include('user.activity.activity.post.posts-object-content',
                        [
                            'modelUser' => $modelUser,
                            'dataUserPost' => $dataUserPost
                        ])
                </div>
            </div>
            {{--building statistic--}}
            <div class="tf-user-activity-object-statistic text-right col-xs-12 col-sm-12 col-md-12 col-lg-12">
                {{--comment--}}

                <i class="glyphicon glyphicon-comment"></i>
                <span class="tf_user_activity_post_comment_total">{!! $dataUserPost->totalComment() !!}</span>
                <a class="tf-link" href="#">Comment</a>
                &nbsp;

                {{--love--}}
                <i class="glyphicon glyphicon-thumbs-up"></i>
                <span class="tf_user_activity_post_love_total">{!! $dataUserPost->totalLove() !!}</span>
                @if($loginStatus)
                    @if($dataUserLogin->existUserLoveUserPost($postId))
                        <?php $labelLove = 'UnLove'; ?>
                    @else
                        <?php $labelLove = 'Love'; ?>
                    @endif
                    <a class="tf_user_activity_post_love tf-link"
                       data-href="{!! route('tf.user.activity.post.love') !!}">{!! $labelLove !!}</a>
                @else
                    <span class="tf-color-grey">love</span>
                @endif

                &nbsp;
                {{--Share--}}
                {{--
                <i class="glyphicon glyphicon-random"></i>
                <span> 12 </span>
                <span class="tf-link">Share</span>
                --}}

            </div>

            {{--comment--}}

            @include('user.activity.activity.post.comments.comment-list',
                [
                    'modelUser'=>$modelUser,
                    'dataUserPost' =>$dataUserPost,
                ])

        </div>

    </div>
</div>