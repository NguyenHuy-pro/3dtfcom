<?php
/**
 *
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/15/2016
 * Time: 12:42 PM
 *
 * $modelUser
 * $skip
 * $take
 * $dataFriendRequestSent
 *
 *
 */

$dataUserLogin = $modelUser->loginUserInfo();
$newSkip = $skip + $take;
?>
@if(count($dataFriendRequestSent) > 0)
    <?php
    $userLoginId = $dataUserLogin->userId();
    $dataMoreSent = $modelUser->infoFriendRequestSent($userLoginId, $newSkip, $take);
    ?>
    @foreach($dataFriendRequestSent as $itemRequest)
        <?php
        #user receive friend request
        $requestUserId = $itemRequest->requestUserId();

        $dataUserRequest = $modelUser->getInfo($requestUserId);
        $pathAvatar = $dataUserRequest->pathSmallAvatar($requestUserId, true);
        $alias = $dataUserRequest->alias();
        ?>
        <table class="tf_user_friend_request_sent_object tf-user-friend-request-sent-object table table-bordered"
               data-user="{!! $requestUserId !!}">
            <tr>
                <td class="tf-padding-none col-xs-4 col-sm-3 col-md-2 col-lg-2">
                    <img class="tf-avatar" alt="{!! $alias !!}" src="{!! $pathAvatar !!}">
                </td>
                <td class="tf-vertical-middle col-xs-4 col-sm-6 col-md-8 col-lg-8 ">
                    <a class="tf-link" href="{!! route('tf.user.home', $alias) !!}">
                        {!! $dataUserRequest->fullName() !!}
                    </a>
                </td>
                <td class="tf-vertical-middle text-right col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                    <a class="tf_user_friend_request_cancel btn btn-default btn-xs tf-link"
                       data-href="{!! route('tf.user.friend.request.cancel') !!}">
                        {!! trans('frontend_user.friend_sent_menu_cancel') !!}
                    </a>
                </td>
            </tr>
        </table>
    @endforeach
    @if(count($dataMoreSent) > 0)
        <div id="tf_user_friend_request_sent_more" class="text-center">
            <a class="tf-link" data-skip="{!! $newSkip !!}" data-take="{!! $take !!}"
               data-href="{!! route('tf.user.friend.request.sent.more') !!}">
                {!! trans('frontend_user.friend_info_view_more') !!}
            </a>
        </div>
    @endif
@endif