<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 3/7/2017
 * Time: 1:10 PM
 *
 *
 * $modelUser
 * dataBuilding
 *
 */

#login info
$dataUserLogin = $modelUser->loginUserInfo();
?>
<ul class="nav nav-pills tf_building_notify_wrap tf-building-notify-wrap" role="tablist">
    @if($dataBuilding->checkNewNotifyOfUser($dataUserLogin->userId()))
        <li class="tf_comment_notify tf-padding-rig-4 "
            data-href="{!! route('tf.map.building.comment.index') !!}">
            <i class="tf-link-yellow fa fa-comments tf-font-size-20"
               title="{!! trans('frontend_map.building_menu_comment_title') !!}"></i>
        </li>
    @endif
</ul>
