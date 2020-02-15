<?php
/*
 *
 *
 * $modelUser
 * $dataUser
 * dataAccess
 * friendObject
 *
 *
 */


# user info access
$userAccessId = $dataUser->userId();

# login info
$dataUserLogin = $modelUser->loginUserInfo();
if (count($dataUserLogin) > 0) {
    $userLoginId = $dataUserLogin->userId();
    if ($userLoginId == $userAccessId) {
        $totalFriendRequestReceived = $dataUser->totalNewFriendRequest($userAccessId);
        $totalFriendRequestSent = $dataUser->totalSentFriendRequest($userAccessId);
    }
    $loginStatus = true;
} else {
    $loginStatus = false;
}
$totalFriend = $dataUser->totalFriend($userAccessId);

$friendObject = $dataAccess['friendObject'];
?>
@extends('user.index')

@section('titlePage')
    {!! trans('frontend_user.title_page_friend') !!}
@endsection

{{--insert js to process  friend  --}}
@section('tf_user_page_js_header')
    <script src="{{ url('public/user/js/user-friend.js')}}"></script>
@endsection


@section('tf_user_content')
    <div class="panel panel-default tf-border-none tf-bg-white">
        <div class="panel-heading tf-padding-none tf-border-bot-none">
            <ul class="nav nav-tabs" role="tablist">
                <li class="@if($friendObject == 'list') active  @endif">
                    <a href="{!! route('tf.user.friend.list') !!}">
                        {!! trans('frontend_user.friend_menu_list') !!}({!! $totalFriend !!})
                    </a>
                </li>
                @if($loginStatus)
                    @if($userLoginId == $userAccessId)
                        {{--Owned --}}
                        {{--receive--}}
                        <li class="@if($friendObject == 'receiveRequest') active @endif">
                            <a href="{!! route('tf.user.friend.request.received') !!}">
                                {!! trans('frontend_user.friend_menu_received_request') !!}
                                ({!! $totalFriendRequestReceived !!})
                            </a>
                        </li>

                        {{--sent--}}
                        <li class="@if($friendObject == 'sentRequest') active @endif">
                            <a href="{!! route('tf.user.friend.request.sent.list') !!}">
                                {!! trans('frontend_user.friend_menu_sent_request') !!}
                                ({!! $totalFriendRequestSent !!})
                            </a>
                        </li>
                    @endif
                @endif
            </ul>
        </div>
        <div class="panel-body tf-border-none">
            @if($friendObject == 'list')
                @include('user.friend.friend.list',
                    [
                        'modelUser'=>$modelUser,
                        'dataUser' => $dataUser
                    ])
            @elseif($friendObject == 'receiveRequest')
                @include('user.friend.request.receive-request',
                    [
                        'modelUser'=>$modelUser,
                        'dataUser' => $dataUser
                    ])
            @elseif($friendObject == 'sentRequest')
                @include('user.friend.request.sent-request',
                    [
                        'modelUser'=>$modelUser,
                        'dataUser' => $dataUser
                    ])
            @endif
        </div>
    </div>
@endsection