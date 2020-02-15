<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/19/2016
 * Time: 8:53 AM
 *
 * $modelUser
 * $dataUser
 *
 *
 */

# user info access
$userAccessId = $dataUser->userId();
$skip = 0;
$take = 10;

# invite info
$inviteInfo = $dataUser->bannerLicenseInviteInfoByUser();
?>
<div class="tf_user_banner_container tf-padding-none col-xs-12 col-sm-12 col-md-12 col-lg-12 " data-user="{!! $userAccessId !!}">

    <div class="row">
        @if(count($inviteInfo) > 0)
            <div class="tf_user_content_invite_list tf-bg-white tf-padding-none col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                @foreach($inviteInfo as $dataBannerLicenseInvite)
                    <?php
                    $n_o = (isset($n_o)) ? $n_o + 1 : 1;
                    ?>
                    @include('user.banner.invite.invite-object', compact('dataBannerLicenseInvite'),
                        [
                            'modelUser'=> $modelUser,
                            'n_o' => $n_o
                        ])
                @endforeach

            </div>
        @else
            <div class="tf-bg-white text-center col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                <em>{!! trans('frontend_user.banner_list_null_notify') !!}</em>
            </div>
        @endif
    </div>

</div>
