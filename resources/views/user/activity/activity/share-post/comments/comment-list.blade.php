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
 * $dataBuildingPost
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

#post info


#comment info
$take = 3;
$dateTake = $hFunction->createdAt();


?>
<div class="row">

    {{--form comment--}}
    <div class="tf-vertical-bottom col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form class="tf_user_activity_posts_comment_frm input-group" method="post" action="#" style="background-color: whitesmoke;">
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

    {{--contain comment--}}
    <div class="tf_user_activity_posts_comment_list col-xs-12 col-sm-12 col-md-12 col-lg-12">
        @include('user.activity.activity.banner-image.comments.comment-object')
    </div>

    {{--view more old comment--}}
    <div class="tf-padding-lef-30 tf-padding-top-5 tf-padding-bot-5 col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <img class="tf-icon-16" src="{!! asset('public\imgsample\contactMessage-off.png') !!}">
        <a class="tf-link" data-take="" data-href="#">
            {!! trans('frontend_building.post_comment_view_more') !!}
        </a>
    </div>

</div>
