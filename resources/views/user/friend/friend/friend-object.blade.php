<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/15/2016
 * Time: 9:26 AM
 *
 * $modelUser
 * $dataUser
 * $dataUserFriend
 * $skip
 * $take
 */

$newSkip = $skip + $take;

$dataUserLogin = $modelUser->loginUserInfo();
# access user info
$userAccessId = $dataUser->userId();
?>
@if(count($dataUserFriend) > 0)
    <?php
    $dataMoreFriend = $dataUser->infoFriend($userAccessId, $newSkip, $take);
    ?>
    @foreach($dataUserFriend as $friendObject)
        <?php
        $userId = $friendObject->userId();
        $alias = $friendObject->alias();
        $pathAvatar = $friendObject->pathSmallAvatar($userId, true);
        ?>
        <table class="tf_user_friend_object tf-user-friend-object table table-bordered" data-user="{!! $userId !!}">
            <tr>
                <td class="tf-padding-none col-xs-4 col-sm-4 col-md-2 col-lg-2">
                    <img class="tf-avatar" alt="{!! $friendObject->alias() !!}" src="{!! $pathAvatar !!}">
                </td>
                <td class="tf-vertical-middle col-xs-4 col-sm-4 col-md-7 col-lg-7 ">
                    <a class="tf-link" href="{!! route('tf.user.home', $alias) !!}">
                        {!! $friendObject->fullName() !!}
                    </a>
                </td>
                <td class="tf-vertical-middle text-right col-xs-4 col-sm-4col-md-3 col-lg-3 ">
                    @if(count($dataUserLogin) > 0)
                        <?php
                        $userLoginId = $dataUserLogin->userId();
                        ?>
                        @if($userLoginId == $userAccessId)
                            {{--access user = user login--}}
                            <a class="tf_user_friend_delete btn btn-default btn-xs tf-link">
                                {!! trans('frontend_user.friend_list_menu_delete') !!}
                            </a>
                        @else
                            {{--access user # user login--}}
                            @if($userLoginId != $userId)
                                {{--user login # firend of access user--}}
                                @if($dataUserLogin->checkFriend($userLoginId, $userId))
                                    {{--had befriended.--}}
                                    <span class="tf-color-grey btn btn-default btn-xs">
                                        {!! trans('frontend_user.friend_list_menu_friend') !!}
                                    </span>
                                @else
                                    @if($dataUserLogin->checkSentFriendRequest($userLoginId, $userId))
                                        <span class="tf-color-grey">
                                            {!! trans('frontend_user.friend_list_menu_sent_request_notify') !!}
                                        </span>
                                    @else
                                        @if($dataUserLogin->checkReceiveFriendRequest($userLoginId, $userId))
                                            <span class="tf-color-grey">
                                                {!! trans('frontend_user.friend_list_menu_receive_request_notify') !!}
                                            </span>
                                        @else
                                            {{--doesn't send--}}
                                            <span class="tf_friend_request tf-link tf-padding-5"
                                                  data-href="{!! route('tf.user.friend.request.send') !!}">
                                                 {!! trans('frontend_user.friend_list_menu_sent_request') !!}
                                            </span>
                                        @endif
                                    @endif
                                @endif
                            @endif
                        @endif
                    @endif
                </td>
            </tr>
        </table>
    @endforeach
    @if(count($dataMoreFriend) > 0)
        <div id="tf_user_friend_more" class="text-center">
            <a class="tf-link" data-user="{!! $userAccessId !!}" data-skip="{!! $newSkip !!}" data-take="{!! $take !!}"
               data-href="{!! route('tf.user.friend.more') !!}">
                {!! trans('frontend_user.friend_info_view_more') !!}
            </a>
        </div>
    @endif
@endif
