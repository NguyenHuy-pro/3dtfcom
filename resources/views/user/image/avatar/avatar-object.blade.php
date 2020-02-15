<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/29/2016
 * Time: 12:28 PM
 */
/*
 * $modelUser
 * $dataUserImage
 */
$dataUserLogin = $modelUser->loginUserInfo();
#action info
$userImageId = $dataUserImage->userId();
$actionStatus = false;
if (count($dataUserLogin) > 0) {
    # image owner
    if ($dataUserLogin->userId() == $userImageId) $actionStatus = true;
}

?>
<div class="tf_image_object col-xs-6 col-sm-4 col-md-3 col-lg-3 tf-image-object"
     data-image="{!! $dataUserImage->imageId() !!}"
     data-date="{!! $dataUserImage->createdAt() !!}">
    <img class="tf_view tf-image tf-link"
         alt="develop-seo" src="{!! $dataUserImage->pathSmallImage() !!}"/>
    @if($actionStatus)
        <a class="glyphicon glyphicon-remove tf_delete tf-delete tf-link-red"></a>
    @endif
</div>
