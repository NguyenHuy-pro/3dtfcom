<?php
/*
 * modelUser
 * dataUser
 * dataAdsBannerLicense
 * skip
 * take
 */

$newSkip = $skip + $take;

# access user info
$userAccessId = $dataUser->userId();
?>
@if(count($dataAdsBannerLicense) > 0)
    <?php
    $dataMoreAdsLicense = $dataUser->adsBannerLicenseOfUser($userAccessId, $newSkip, $take);
    ?>
    @foreach($dataAdsBannerLicense as $adsLicenseObject)
        <?php
        $licenseId = $adsLicenseObject->licenseId();
        $n_o = (isset($n_o)) ? $n_o + 1 : $skip + 1;

        $dataAdsBanner = $adsLicenseObject->adsBanner;
        $name = $dataAdsBanner->name();

        $dataAdsBannerImage = $adsLicenseObject->adsBannerImageAvailable();
        ?>
        <table class="tf_user_ads_object  tf-user-ads-object table table-hover"
               data-license="{!! $licenseId !!}" data-name="{!! $adsLicenseObject->name() !!}">
            <tr>
                <td class="tf-vertical-middle col-xs-2 col-sm-2 col-md-2 col-lg-2 ">
                    <b>{!! $n_o !!} .</b>&nbsp;
                    {!! $name !!}
                </td>
                <td class="tf-vertical-middle col-xs-4 col-sm-4 col-md-4 col-lg-4 ">
                    @if(count($dataAdsBannerImage) > 0)
                        <img class="tf-image" src="{!! $dataAdsBannerImage->pathImage() !!}">
                    @else
                        <em>
                            Null
                        </em>
                    @endif
                </td>
                <td class="tf-vertical-middle col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    {!! $adsLicenseObject->display()  !!}
                </td>
                <td class="tf-vertical-middle text-right col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    @if(count($dataAdsBannerImage) > 0)
                        <em>
                            {!! \Carbon\Carbon::parse($dataAdsBannerImage->createdAt())->format('Y-m-d')  !!}
                        </em>
                    @else
                        <a class="tf_ads_banner_set_img  btn btn-default tf-link"
                           data-href="{!! route('tf.user.ads.set-image.get') !!}">
                            Set image
                        </a>
                    @endif
                </td>
            </tr>
        </table>
    @endforeach
    @if(count($dataMoreAdsLicense) > 0)
        <div id="tf_user_ads_more" class="text-center">
            <a class="tf-link" data-user="{!! $userAccessId !!}" data-skip="{!! $newSkip !!}" data-take="{!! $take !!}"
               data-href="{!! route('tf.user.ads.more') !!}">
                {!! trans('frontend_user.ads_list_more_label') !!}
            </a>
        </div>
    @endif
@endif