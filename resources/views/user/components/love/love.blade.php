<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/25/2016
 * Time: 10:28 AM
 *
 * $modelUser
 * $dataUser
 *
 *
 */

# user login info
$loginStatus = $modelUser->checkLogin();
if ($loginStatus) $loginUserId = $modelUser->loginUserId();

#access user info
$accessUserId = $dataUser->userId();
?>
<div class="col-xs-12 col-sm-12 col-md-12 text-left tf-padding-top-10 tf-padding-bot-10">
    <i class="fa fa-thumbs-up tf-font-size-16 tf-color"></i>
    {!! $dataUser->totalLoved() !!}
    &nbsp;
    @if($loginStatus)
        @if($dataUser->checkLoveUser($accessUserId,$loginUserId))
            <a class="tf_user_love tf-link fa fa-minus tf-font-size-16" data-user="{!! $accessUserId !!}"
               data-href="{!! route('tf.user.friend.love.minus') !!}"></a>
        @else
            <a class="tf_user_love tf-link fa fa-plus tf-font-size-16" data-user="{!! $accessUserId !!}"
               data-href="{!! route('tf.user.friend.love.plus') !!}"></a>
        @endif
    @endif
</div>
