<?php
/*
 *
 *
 * modelUser
 * dataUserPost
 *
 *
 */
#post info
$postCode = $dataUserPost->postCode();
$postContent = $dataUserPost->content();
$postImage = $dataUserPost->image();

#user post info
$dataUserPostInfo = $dataUserPost->userPost;
$userPostAvatarPath = $dataUserPostInfo->pathSmallAvatar($dataUserPostInfo->userId(), true);
$userPostAlias = $dataUserPostInfo->alias();

// user wall info
$dataUserWallInfo = $dataUserPost->userWall;

?>
@extends('user.index')

@section('tf_user_content')
    <div id="tf_user_activity_post_detail"
         class="tf-user-activity-post-detail tf-padding-top-20 col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <table class="table">
            <tr>
                <td class="tf-border-top-none">
                    <div class="media">
                        <a class="pull-left" href="{!! route('tf.user.home',$userPostAlias) !!}">
                            <img class="media-object tf-border tf-icon-50 tf-border-radius-4" alt="keyword-seo"
                                 src="{!! $userPostAvatarPath !!}">
                        </a>
                        <div class="media-body">
                            <p class="media-heading">
                                <a class="tf-link-bold" href="{!! route('tf.user.home',$userPostAlias) !!}">
                                    {!! $dataUserPostInfo->fullName() !!}
                                </a>
                                @if($dataUserPostInfo->userId() !== $dataUserWallInfo->userId())
                                    &nbsp;
                                    <i class="tf-color-grey tf-font-size-12 glyphicon glyphicon-play"></i>
                                    &nbsp;
                                    <a class="tf-link" href="{!! route('tf.user.activity.get', $dataUserWallInfo->alias()) !!}">
                                        {!! $dataUserWallInfo->fullName() !!}
                                    </a>
                                @endif
                            </p>
                            <span>{!! $dataUserPost->createdAt() !!}</span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="tf-border-none">
                    <div id="tf_user_activity_post_detail_content" class="tf-overflow-prevent">
                        {!! $postContent !!}
                    </div>
                </td>
            </tr>
            @if(!empty($postImage))
                <tr>
                    <td class="tf-overflow-prevent tf-border-none">
                        <img src="{!! $dataUserPost->pathSmallImage() !!}">
                    </td>
                </tr>
            @endif
        </table>
        <script type="text/javascript">
            //set width to use word-wrap
            var wrapWidth = $('#tf_user_activity_post_detail').outerWidth();
            $('#tf_user_activity_post_detail_content').css({'width': wrapWidth - 40});
        </script>
    </div>
@endsection