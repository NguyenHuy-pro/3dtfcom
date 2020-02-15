<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/29/2016
 * Time: 10:54 AM
 */
/*
 * $modelUser
 * $dataUserImage
 */

$dataUserLogin = $modelUser->loginUserInfo();

#user info
$userImageId = $dataUserImage->userId();

$actionStatus = false;
if (count($dataUserLogin) > 0) {
    # image owner
    if ($dataUserLogin->userId() == $userImageId) $actionStatus = true;
}

?>
<div class="tf_image_object tf-image-object col-xs-6 col-sm-4 col-md-3 col-lg-3 "
     data-image="{!! $dataUserImage->imageId() !!}"
     data-date="{!! $dataUserImage->createdAt() !!}">
    <div class="tf-image-object-wrap">
        <img class="tf_view tf-image tf-link"
             alt="develop-seo" src="{!! $dataUserImage->pathSmallImage() !!}"/>
        @if($actionStatus)
            <a class="glyphicon glyphicon-remove tf_delete tf-delete tf-link-red"></a>
        @endif
    </div>
</div>
