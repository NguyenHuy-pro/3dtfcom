<?php
/*
 * $modelUser
 * $dataUser
 */

# user info access
$userAccessId = $dataUser->userId();
$skip = 0;
$take = 30;
$dataUserFriend = $dataUser->infoFriend($userAccessId, $skip, $take);
?>
@if(count($dataUserFriend) > 0)
    <div id="tf_user_friend" class="tf-padding-none col-xs-12 col-sm-12 col-md-12 col-lg-12"
         data-href-delete="{!! route('tf.user.friend.delete') !!}">

        @include('user.friend.friend.friend-object',compact('dataUserFriend'),
            [
                'modelUser' =>$modelUser,
                'dataUser' => $dataUser,
                'skip' => $skip,
                'take' =>$take,
            ])

    </div>
@endif