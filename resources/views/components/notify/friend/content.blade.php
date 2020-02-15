<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/16/2016
 * Time: 5:01 PM
 *
 * modelUser
 * modelUserFriendRequest
 * dataNotifyFriend
 *
 */

?>
@extends('components.notify.notify-wrap')
@section('tf_notify_top')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <i class=" fa fa-users tf-font-size-14 tf-color-grey"></i>
        {!! trans('frontend.notify_friend_title') !!}
    </div>
@endsection

@section('tf_notify_content')
    <div class="row">
        <table class="table table-hover">
            @if(count($dataNotifyFriend) > 0)
                @foreach($dataNotifyFriend as $value)
                    <?php
                    $objectId = $value->objectId;
                    ?>
                    @if($value->object == 'friendRequest')
                        <?php
                        $dataFriendRequest = $modelUserFriendRequest->getInfo($objectId);
                        $userSendRequestId = $dataFriendRequest->userId();
                        $dataUserRequest = $modelUser->getInfo($userSendRequestId);
                        $pathAvatar = $dataUserRequest->pathSmallAvatar($dataUserRequest->userId(), true);
                        ?>
                        <tr class="tf_notify_friend_object tf-border-bottom" data-request="{!! $objectId !!}">
                            <td class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <img class="avatar tf-icon-50" alt="avatar-of-user" src="{!! $pathAvatar !!}">
                            </td>
                            <td class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                <a class="tf-link" href="{!! route('tf.user.home', $dataUserRequest->alias()) !!}"
                                   target="_blank">
                                    {!! $dataUserRequest->fullName() !!}
                                </a>
                                sent a friend request to you

                            </td>
                            <td class="tf_notify_friend_confirm col-xs-2 col-sm-2 col-md-2 col-lg-2"
                                data-user="{!! $userSendRequestId !!}">
                                <a class=" btn btn-primary btn-xs"
                                   data-href="{!! route('tf.user.friend.request.confirm.yes') !!}">
                                    {!! trans('frontend.notify_friend_menu_accept') !!}
                                </a><br>
                                <a class=" btn btn-default btn-xs tf-margin-top-5"
                                   data-href="{!! route('tf.user.friend.request.confirm.no') !!}">
                                    {!! trans('frontend.notify_friend_menu_delete') !!}
                                </a>
                            </td>
                        </tr>
                    @elseif($value->object == 'friend')
                        <?php
                        $dataUserFriend = $modelUser->getInfo($objectId);
                        $pathAvatar = $dataUserFriend->pathSmallAvatar($objectId, true);
                        ?>
                        <tr class="tf_notify_friend_object tf-border-bottom" data-user-friend="{!! $objectId !!}">
                            <td class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <img class="avatar tf-icon-50" alt="avatar-of-user" src="{!! $pathAvatar !!}">
                            </td>
                            <td class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                <a class="tf-link" href="{!! route('tf.user.home', $dataUserFriend->alias()) !!}"
                                   target="_blank">
                                    {!! $dataUserFriend->fullName() !!}
                                </a>
                                accepted your request

                            </td>
                            <td class="tf_notify_friend_hide col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <a class=" btn btn-default btn-xs tf-margin-top-5"
                                   data-href="{!! route('tf.notify.friend.hide') !!}">
                                    {!! trans('frontend.notify_friend_menu_hide') !!}
                                </a>
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endif
        </table>
    </div>
@endsection

@section('tf_notify_bottom')
    <a class="tf_main_wrap_remove tf-link-full tf-color-red tf-bg-hover">
        {!! trans('frontend.button_close') !!}
    </a>
@endsection
