<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/13/2016
 * Time: 4:40 PM
 *
 * $modelUser
 * $dataUser
 */

$dataUserLogin = $modelUser->loginUserInfo();
# user info access
$userAccessId = $dataUserLogin->userId();
$skip = 0;
$take = 2;
$dataFriendRequestSent = $modelUser->infoFriendRequestSent($userAccessId, $skip, $take);
?>
@if(count($dataFriendRequestSent) > 0)
    <div id="tf_user_friend_request_sent" class="tf-padding-none col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        @include('user.friend.request.sent-request-object',compact('dataFriendRequestSent'),
            [
                'modelUser' => $modelUser,
                'skip' => $skip,
                'take' => $take,
            ])
    </div>
@endif
