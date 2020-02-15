<?php
/*
 *
 * $modelUser
 * $dataBannerLicense
 * $skip
 * $take
 *
 *
 */

$newSkip = $skip + $take;

# access user info
$userAccessId = $dataUser->userId();
?>
@if(count($dataBannerLicense) > 0)
    <?php
    $dataMoreBannerLicense = $dataUser->bannerLicenseOfUser($userAccessId, $newSkip, $take);
    ?>
    @foreach($dataBannerLicense as $bannerLicenseObject)
        <?php
        $bannerId = $bannerLicenseObject->bannerId();
        $n_o = (isset($n_o)) ? $n_o + 1 : $skip + 1;
        $dateEnd = $bannerLicenseObject->dateEnd();
        $dateEnd = date_create($dateEnd);

        $dataBanner = $bannerLicenseObject->banner;
        $name = $dataBanner->name();
        $dataBannerImage = $dataBanner->imageInfo();
        if(count($dataBannerImage) > 0){
            $pathImage = $dataBannerImage->pathSmallImage();
        }else{
            $pathImage = asset('public/main/icons/banner-icon.png');
        }
        ?>
        <table class="tf_user_banner_object table table-hover  tf-border-none " data-banner="{!! $bannerId !!}">
            <tr>
                <td class="tf-vertical-middle tf-border-none col-md-4  ">
                    <b>{!! $n_o !!}. </b>&nbsp;
                    <img style="max-width: 64px; max-height: 96px;" src="{!! $pathImage  !!}">

                </td>
                <td class="tf-vertical-middle tf-border-none col-md-4">
                    <a class="tf-link" href="{!! route('tf.map.banner.access',$bannerId ) !!}" target="_blank">
                        {!! $name !!} &nbsp;<i class="fa fa-map-marker tf-font-size-14"></i>
                    </a>
                </td>
                <td class="col-md-4 tf-vertical-middle text-center tf-border-none" title="expiry date">
                    <span class="glyphicon glyphicon-calendar"></span> {!! date_format($dateEnd, 'd-m-Y')  !!}
                </td>
            </tr>
        </table>
    @endforeach
    @if(count($dataMoreBannerLicense) > 0)
        <div id="tf_user_banner_more" class="text-center">
            <a class="tf-link" data-user="{!! $userAccessId !!}" data-skip="{!! $newSkip !!}" data-take="{!! $take !!}"
               data-href="{!! route('tf.user.banner.more') !!}">
                {!! trans('frontend_user.banner_info_view_more') !!}
            </a>
        </div>
    @endif

@endif