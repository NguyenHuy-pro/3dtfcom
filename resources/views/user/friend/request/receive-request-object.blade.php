<?php
/**
 *
 *
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/14/2016
 * Time: 12:05 PM
 *
 * $modelUser
 * $skip
 * $take
 * $dataFriendRequestReceived
 *
 *
 */

$dataUserLogin = $modelUser->loginUserInfo();
$newSkip = $skip + $take;
?>
@if(count($dataFriendRequestReceived) > 0)
    <?php
    $userLoginId = $dataUserLogin->userId();
    $dataMoreReceive = $dataUserLogin->infoFriendRequestReceived($userLoginId, $newSkip, $take);
    ?>
    @foreach($dataFriendRequestReceived as $itemRequest)
        <?php
        $userId = $itemRequest->userId();
        $dataUserRequest = $modelUser->getInfo($userId);
        $alias = $dataUserRequest->alias();
        $pathAvatar = $dataUserRequest->pathSmallAvatar($userId, true);
        ?>
        <table class="tf_user_friend_request_receive_object tf-user-friend-request-receive-object table table-bordered"
               data-user="{!! $userId !!}">
            <tr>
                <td class="tf-padding-none col-xs-4 col-sm-4 col-md-2 col-lg-2">
                    <img class="tf-avatar" alt="{!! $alias !!}" src="{!! $pathAvatar !!}">
                </td>
                <td class="tf-vertical-middle col-xs-4 col-sm-4 col-md-7 col-lg-7">
                    <a class="tf-link" href="{!! route('tf.user.home', $alias) !!}">
                        {!! $dataUserRequest->fullName() !!}
                    </a>
                </td>
                <td class="tf-vertical-middle text-right col-xs-4 col-sm-4 col-md-3 col-lg-3">
                    <a class="tf_user_friend_confirm_yes btn btn-primary btn-xs tf-link-white " >
                        {!! trans('frontend_user.friend_receive_menu_accept') !!}
                    </a>
                    <a class="tf_user_friend_confirm_no btn btn-default btn-xs tf-link">
                        {!! trans('frontend_user.friend_receive_menu_later') !!}
                    </a>
                </td>
            </tr>
        </table>
    @endforeach
    @if(count($dataMoreReceive) > 0)
        <div id="tf_user_friend_request_receive_more" class="text-center">
            <a class="tf-link" data-skip="{!! $newSkip !!}" data-take="{!! $take !!}"
               data-href="{!! route('tf.user.friend.request.received.more') !!}">
                {!! trans('frontend_user.friend_info_view_more') !!}
            </a>
        </div>
    @endif
@endif
