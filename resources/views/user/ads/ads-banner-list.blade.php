<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/19/2016
 * Time: 8:53 AM
 *
 *
 * $modelUser
 * $dataUser
 */

# user info access
$userAccessId = $dataUser->userId();
$skip = 0;
$take = 20;
$dataAdsBannerLicense = $dataUser->adsBannerLicenseOfUser($userAccessId, $skip, $take);

?>
<div id="tf_user_ads" class="tf_user_ads tf-padding-none col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
    <table class="table">
        <tr>
            <th class="tf-vertical-middle tf-border-none col-xs-2 col-sm-2 col-md-2 col-lg-2 ">
                {!! trans('frontend_user.ads_list_name_label') !!}
            </th>
            <th class="tf-vertical-middle tf-border-none col-xs-4 col-sm-4 col-md-4 col-lg-4 ">
                {!! trans('frontend_user.ads_list_image_label') !!}
            </th>
            <th class="tf-vertical-middle tf-border-none col-xs-2 col-sm-2 col-md-2 col-lg-2 ">
                {!! trans('frontend_user.ads_list_show_label') !!}
            </th>
            <th class="tf-border-none col-xs-4 col-sm-4 col-md-4 col-lg-4">

            </th>
        </tr>
    </table>
    @include('user.ads.ads-banner-object',compact('dataAdsBannerLicense'),
        [
            'modelUser' => $modelUser,
            'dataUser' => $dataUser,
            'skip' => $skip,
            'take' => $take
        ])
</div>
