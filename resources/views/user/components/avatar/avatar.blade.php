<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 2/18/2017
 * Time: 1:05 AM
 *
 * $modelUser
 * $dataUserAccess
 *
 */


#user login info
$loginStatus = $modelUser->checkLogin();
if ($loginStatus) $loginUserId = $modelUser->loginUserId();

#access user

$userId = $dataUser->userId();
$dataImageAvatar = $modelUser->imageAvatarInfoUsing($userId);
$pathImage = $modelUser->pathSmallAvatar($userId, true);
?>

<div class="tf_user_title_avatar tf-user-title-avatar">

    {{--avatar--}}
    @if(count($dataImageAvatar) > 0)
        <img class="tf_avatar tf-avatar tf-link" data-image="{!! $dataImageAvatar->imageId() !!}"
             alt="{!! $dataUser->alias() !!}" data-href="{!! route('tf.user.title.avatar.view.get') !!}"
             src="{!! $pathImage !!}">
    @else
        <img class="tf-avatar" alt="{!! $dataUser->alias() !!}" src="{!! $pathImage !!}">
    @endif

    @if($loginStatus && $userId == $loginUserId)
        <div class="tf_user_avatar_menu_wrap tf-user-avatar-menu-wrap">
            <a class="dropdown-toggle tf-padding-5 tf-border-radius-5 tf-link-grey " data-toggle="dropdown" style="background-color: #D7D7D7;">
                <img class="tf-icon-20 " alt="camera" src="{!! asset('public\main\icons\Photograph.png') !!}">
            </a>
            <ul class="dropdown-menu dropdown-menu-left tf-padding-none">
                <li>
                    <a class="tf_avatar_edit_get tf-bg-hover tf-link-hover-white"
                       data-href="{!! route('tf.user.title.avatar.edit.get') !!}">
                        {!! trans('frontend_user.avatar_menu_edit') !!}
                    </a>
                </li>
                @if(count($dataImageAvatar) > 0)
                    <li>
                        <a class="tf_avatar_delete tf-bg-hover tf-link-hover-white"
                           data-image="{!! $dataImageAvatar->imageId() !!}"
                           data-href="{!! route('tf.user.title.avatar.delete.get') !!}">
                            {!! trans('frontend_user.avatar_menu_delete') !!}
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    @endif

</div>