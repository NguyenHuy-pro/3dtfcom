<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/5/2016
 * Time: 1:36 PM
 */
/*
 *
 * $modelUser
 * $dataUserPost
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

#post info
$postId = $dataUserPost->postId();

#comment info
$take = 3;
$dateTake = $hFunction->createdAt();
$result = $dataUserPost->commentInfoOfPost($postId, $take, $dateTake);

?>

<div class="row">

    {{--form comment--}}
    @if($loginStatus)
        <div class="tf-vertical-bottom col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <form class="tf_frm_user_activity_posts_comment input-group" method="post"
                  action="{!! route('tf.user.activity.post.comment.add.post') !!}" style="background-color: whitesmoke;">
                <textarea class="form-control txt_comment_content tf-bg-none tf-border-none" name="txtCommentContent"
                          rows="1" placeholder="Enter comment"></textarea>
                <span class="input-group-btn tf-border-none">
                    <a class="tf_send tf-link">
                        <button class="btn btn-default tf-border-none tf-bg-none" type="button">
                            {!! trans('frontend.button_send') !!}
                        </button>
                    </a>
                </span>
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            </form>
        </div>
    @else
        <div class="tf-padding-lef-30 col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
            <em class="tf-color-grey">You must login to Comment</em>
        </div>
    @endif

    {{--contain comment--}}
    <div id="tf_user_activity_post_comment_list_{!! $postId !!}" class="tf_user_activity_post_comment_list col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        @if(count($result) > 0)
            @foreach($result as $dataUserPostComment)
                @include('user.activity.activity.post.comments.comment-object', compact('dataUserPostComment'),
                    [
                        'modelUser'=>$modelUser
                    ])
                <?php
                $checkDate = $dataUserPostComment->createdAt();
                ?>
            @endforeach
        @endif
    </div>

    {{--view more old comment--}}
    @if(count($result) > 0)
        <?php
        #check exist of comment
        $resultMore = $dataUserPost->commentInfoOfPost($postId, $take, $checkDate);
        ?>
        @if(count($resultMore) > 0)
            <div id="tf_user_activity_post_comment_more_{!! $postId !!}"
                 class="tf_comment_view_more tf-padding-lef-30 tf-padding-top-5 tf-padding-bot-5 col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                <img class="tf-icon-16" src="{!! asset('public\main\icons\contactMessage-off.png') !!}">
                <a class="tf-link" data-take="{!! $take !!}" data-post="{!! $postId  !!}"
                   data-href="{!! route('tf.user.activity.post.comment.more.get') !!}">
                    View more comment
                </a>
            </div>
        @endif
    @endif

</div>
