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
$hFunction = new Hfunction();
# user info access
$userAccessId = $dataUser->userId();
$take = 100;
$dateTake = $hFunction->carbonNow();
# invite info
$inviteInfo = $dataUser->landLicenseInviteInfoByUser();
?>
<div class="tf_user_land_container tf-padding-none col-xs-12 col-sm-12 col-md-12 col-lg-12 "
     data-user="{!! $userAccessId !!}">
    <div class="tf_list_content tf-bg-white col-xs-12 col-sm-12 col-md-12 col-lg-12">
        @if(count($inviteInfo) > 0)
            @foreach($inviteInfo as $dataLandLicenseInvite)
                @include('user.land.invite.invite-object', compact('dataLandLicenseInvite'),
                        [
                            'modelUser'=> $modelUser,
                            'dataUser'=> $dataUser
                        ])
                <?php
                $checkDateViewMore = $dataLandLicenseInvite->createdAt();
                ?>
            @endforeach
        @else
            <div class="tf-bg-white text-center tf-color-red col-xs-12 col-sm-12 col-md-12 col-lg-12">
                {!! trans('frontend_user.land_list_null_notify') !!}
            </div>
        @endif
    </div>
    {{--view more old image--}}
    @if(count($inviteInfo) > 0 )
        <?php
        #check exist of image
        $resultMore = $dataUser->landLicenseInviteInfoByUser($userAccessId, $take, $checkDateViewMore);
        ?>
        @if(count($resultMore) > 0)
            <div class="tf_view_more tf-padding-20 text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <a class="tf-link" data-take="{!! $take !!}" data-href="{!! route('tf.user.land.invited.more.get') !!}">
                    View more
                </a>
            </div>
        @endif
    @endif
</div>
