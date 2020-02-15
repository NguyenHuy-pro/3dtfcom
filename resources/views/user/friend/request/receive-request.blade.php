{{--list friend request of user received--}}
<?php
/*
 *
 * $modelUser
 * $dataUserFriend
 *
 *
 */

$dataUserLogin = $modelUser->loginUserInfo();

# user info access
$userAccessId = $dataUserLogin->userId();
$skip = 0;
$take = 2;
$dataFriendRequestReceived = $dataUserLogin->infoFriendRequestReceived($userAccessId, $skip, $take);
?>
@if(count($dataFriendRequestReceived) > 0)
    <div id="tf_user_friend_request_receive" class="tf-padding-none col-xs-12 col-sm-12 col-md-12 col-lg-12 "
         data-href-yes="{!! route('tf.user.friend.request.confirm.yes') !!}"
         data-href-no="{!! route('tf.user.friend.request.confirm.no') !!}">

        @include('user.friend.request.receive-request-object',compact('dataFriendRequestReceived'),
            [
                'modelUser' => $modelUser,
                'skip' => $skip,
                'take' => $take
            ])

    </div>
@endif