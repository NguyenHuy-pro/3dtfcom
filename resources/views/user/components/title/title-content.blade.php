<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/12/2016
 * Time: 1:26 PM
 *
 * $modelUser
 * $dataUser
 * $dataImageBanner
 *
 */

$loginStatus = $modelUser->checkLogin();
if ($loginStatus) $loginUserId = $modelUser->loginUserId();

$userId = $dataUser->userId();
#avatar info
#$dataImageAvatar = $modelUser->imageAvatarInfoUsing($userId);
#$pathImage = $modelUser->pathSmallAvatar($userId, true);

?>
<div class="row">
    <table class="table tf_user_content_title tf-user-content-title">
        <tr>
            {{-- title --}}
            <td class="tf_user_title_banner tf-user-title-banner">
                @include('user.components.avatar.avatar', compact('dataUser'),
                    [
                        'modelUser' =>$modelUser,
                    ])
                {{--banner image--}}
                @if(count($dataImageBanner) > 0)
                    <img class="tf_banner_view tf-user-banner-image tf-link" alt="image"
                         data-image="{!! $dataImageBanner->imageId() !!}"
                         data-href="{!! route('tf.user.title.banner.view.get') !!}"
                         src="{!! $dataImageBanner->pathFullImage() !!}"/>
                @else
                    <img class="tf-user-banner-image" alt="banner"
                         src="{!! $modelUser->pathDefaultBannerImage() !!}"/>
                @endif

                {{--user name--}}
                <div class="tf-user-title-name">
                    <h1 class="tf-font-border-black tf-link-white-bold tf-font-size-24">{!! $dataUser->fullName() !!}</h1>
                </div>

                {{--banner menu--}}
                @if($loginStatus)
                    @if($userId == $loginUserId)

                        {{--banner --}}
                        <div class="tf-user-banner-menu-wrap">
                            <a class="dropdown-toggle tf-cursor-pointer tf-border-radius-5 tf-padding-5"
                               style="background-color: #d7d7d7;" data-toggle="dropdown">
                                <img class="tf-icon-20" alt="icon"
                                     src="{!! asset('public\main\icons\Photograph.png') !!}">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right tf-padding-none">
                                <li>
                                    <a class="tf_banner_edit_get tf-bg-hover tf-link-hover-white "
                                       data-href="{!! route('tf.user.title.banner.edit.get') !!}">
                                        {!! trans('frontend_user.title_banner_menu_edit') !!}
                                    </a>
                                </li>
                                @if(count($dataImageBanner) > 0)
                                    <li>
                                        <a class="tf_banner_delete tf-bg-hover tf-link-hover-white"
                                           data-image="{!! $dataImageBanner->image() !!}"
                                           data-href="{!! route('tf.user.title.banner.delete.get') !!}">
                                            {!! trans('frontend_user.title_banner_menu_delete') !!}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @else
                        {{-- friend --}}
                        <div id="tf_user_title_friend" class="tf-user-title-friend" data-user="{!! $userId !!}">
                            @if($modelUser->checkFriend($loginUserId, $userId))
                                {{--had befriended.--}}
                                <span class="tf-link tf-bg-whitesmoke dropdown-toggle tf-padding-5 tf-border-radius-5 "
                                      data-toggle="dropdown">
                                    {!! trans('frontend_user.title_friend_menu_friend') !!}
                                </span>
                                <ul class="dropdown-menu dropdown-menu-right tf-padding-none">
                                    <li class="">
                                        <a class="tf_friend_delete tf-bg-hover tf-link-hover-white"
                                           data-href="{!! route('tf.user.friend.delete') !!}">
                                            {!! trans('frontend_user.title_friend_menu_unFriend') !!}
                                        </a>
                                    </li>
                                </ul>
                            @else
                                @if($modelUser->checkSentFriendRequest($loginUserId, $userId))
                                    {{--sent friend request--}}
                                    <span class="tf-link tf-bg-whitesmoke tf-padding-5 dropdown-toggle "
                                          data-toggle="dropdown">
                                        {!! trans('frontend_user.title_friend_menu_send_request') !!}
                                    </span>
                                    <ul class="dropdown-menu dropdown-menu-right tf-padding-none">
                                        <li>
                                            <a class="tf_friend_request_cancel tf-link text-center"
                                               data-href="{!! route('tf.user.friend.request.cancel') !!}">
                                                {!! trans('frontend_user.title_friend_menu_cancel_request') !!}
                                            </a>
                                        </li>
                                    </ul>
                                @else
                                    @if($modelUser->checkReceiveFriendRequest($loginUserId, $userId))
                                        {{--user receive friend request of access user--}}
                                        <span class="tf-link tf-bg-white tf-padding-5 dropdown-toggle "
                                              data-toggle="dropdown">
                                            {!! trans('frontend_user.title_friend_menu_have_request') !!}
                                        </span>
                                        <ul class="dropdown-menu dropdown-menu-right tf-margin-top-5 tf-padding-none ">
                                            <li>
                                                <a class="tf_user_friend_confirm_yes tf-bg-hover tf-link-hover-white"
                                                   data-href="{!! route('tf.user.friend.request.confirm.yes') !!}">
                                                    {!! trans('frontend_user.title_friend_menu_agree') !!}
                                                </a>
                                            </li>
                                            <li>
                                                <a class="tf_user_friend_confirm_no tf-bg-hover tf-link-hover-white "
                                                   data-href="{!! route('tf.user.friend.request.confirm.no') !!}">
                                                    {!! trans('frontend_user.title_friend_menu_later') !!}
                                                </a>
                                            </li>
                                        </ul>
                                    @else
                                        {{--doesn't send--}}
                                        <span class="tf_friend_request tf-link tf-bg-whitesmoke tf-padding-5"
                                              data-href="{!! route('tf.user.friend.request.send') !!}">
                                            <i class="fa fa-plus"></i>
                                            {!! trans('frontend_user.title_friend_menu_friend_request') !!}
                                        </span>
                                    @endif
                                @endif
                            @endif
                        </div>
                    @endif
                @endif
            </td>
        </tr>
    </table>
</div>