<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/29/2016
 * Time: 12:28 PM
 */
/*
 *
 * $modelUser
 * $dataBannerShare
 *
 *
 */

$dataUserLogin = $modelUser->loginUserInfo();
#action info
$userShareId = $dataBannerShare->userId();
$actionStatus = false;
if (!empty($dataUserLogin)) {
    # image owner
    if ($dataUserLogin->userId() == $userShareId) $actionStatus = true;
}

$dataBanner = $dataBannerShare->banner;
$dataBannerImage = $dataBanner->imageInfo();
$totalView = $dataBannerShare->totalView();
$totalViewRegister = $dataBannerShare->totalViewRegister();
?>
<table class="tf_share_object table table-hover tf-share-object"
       data-share="{!! $dataBannerShare->shareId() !!}"
       data-date="{!! $dataBannerShare->createdAt() !!}">
    <tr>
        <td class="col-xs-5 col-sm-4 col-md-4">
            <a class="tf-link" href="{!! route('tf.map.banner.access',$dataBanner->bannerId() ) !!}" target="_blank">
                @if(!empty($dataBannerImage))
                    <img style="max-width: 64px; max-height: 32px;" alt="image"
                         src="{!! $dataBannerImage->pathSmallImage() !!}">
                @else
                    <img style="max-width: 64px; max-height: 32px;" alt="banner"
                         src="{!! asset('public/main/icons/banner-icon.png') !!}">
                @endif
                &nbsp;
                {!! $dataBanner->name() !!}
            </a>

        </td>
        <td class="col-xs-2 col-sm-2 col-md-2">
            <i class="fa fa-eye tf-font-size-16 tf-color-grey" title="View"></i>&nbsp;
            @if($totalView > 0)
                <a class="tf_view tf-link">
                    {!! $totalView !!}
                </a>
            @else
                {!! $totalView !!}
            @endif
        </td>
        <td class="col-xs-2 col-sm-2 col-md-2">
            <i class="fa fa-user tf-font-size-16 tf-color-grey" title="Register"></i>+ &nbsp;
            {!! $totalViewRegister !!}
        </td>
        <td class="col-xs-3 col-sm-4 col-md-4 text-right">
            <i class="fa fa-calendar tf-font-size-16 tf-color-grey" title="View"></i>&nbsp;
            {!! $dataBannerShare->createdAt() !!}
        </td>
    </tr>
</table>
