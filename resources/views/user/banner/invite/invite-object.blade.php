<?php
/*
 *
 * $modelUser
 * dataBannerLicenseInvite
 *
 *
 */
$hFunction = new Hfunction();
#banner info
$dataBanner = $dataBannerLicenseInvite->bannerLicense->banner;
$bannerId = $dataBanner->bannerId();

$dataBannerImage = $dataBanner->imageInfo();
# banner image info
if (count($dataBannerImage) > 0) {
    $pathImage = $dataBannerImage->pathSmallImage();
} else {
    $pathImage = $dataBanner->pathIconDefault();
}
?>

<table class="tf_user_banner_object table table-hover  tf-border-none " data-banner="{!! $bannerId !!}">
    <tr>
        <td class="tf-vertical-middle tf-border-none col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <b>{!! $n_o !!}. </b>&nbsp;
            <a class="tf-link" href="{!! route('tf.map.banner.access',$bannerId ) !!}" target="_blank">
                <img style="max-width: 128px; height: 64px;" src="{!! $pathImage  !!}">
            </a>

        </td>
        <td class="tf-vertical-middle tf-border-none col-xs-5 col-sm-5 col-md-5 col-lg-5" title="expiry date">
            <b>To:</b>&nbsp; {!! $dataBannerLicenseInvite->email() !!}
        </td>
        <td class="tf-vertical-middle tf-border-none text-right col-xs-3 col-sm-3 col-md-3 col-lg-3 ">
            {!! $hFunction->dateFormatDMY($dataBannerLicenseInvite->createdAt(),'-') !!}
            <br/>
            <a class="tf_cancel tf-link" data-invite="{!! $dataBannerLicenseInvite->inviteId() !!}" data-href="{!! route('tf.user.banner.invited.cancel') !!}">
                {!! trans('frontend.button_cancel') !!}
            </a>
        </td>
    </tr>
</table>