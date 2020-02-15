<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/20/2016
 * Time: 10:22 AM
 *
 *
 * $modelUser
 * $dataLand
 * $dataLandLicense
 * $dataLandTransaction
 *
 *
 */
$mobileDetect = new Mobile_Detect();
$loginStatus = $modelUser->checkLogin();
$landId = $dataLand->landId();
?>
<ul class="nav nav-pills tf_land_menu tf-land-menu " role="tablist" data-land="{!! $landId !!}">
    {{--check mobile--}}
    @if(!$mobileDetect->isMobile())
        <li class="dropup">
            <a class="dropdown-toggle tf_land_menu_icon tf-color tf-margin-padding-none" data-toggle="dropdown">
                <i class="fa fa-bars tf-font-size-30 tf-cursor-pointer"></i>
            </a>
            <ul class="dropdown-menu tf-padding-none tf-box-shadow">
                {{--help--}}
                <li>
                    <a class="tf-link"
                       href="{!! route('tf.help', 'land/activities') !!}"
                       title="{!! trans('frontend_map.land_menu_help_label') !!}"
                       target="_blank">
                        {!! trans('frontend_map.land_menu_help_label') !!}
                    </a>
                </li>
                <li>
                    <a class="tf_land_share_get tf-link" data-land="{!! $landId !!}"
                       data-href="{!! route('tf.map.land.share.get') !!}"
                       title="{!! trans('frontend_map.land_menu_share_label') !!}">
                        {!! trans('frontend_map.land_menu_share_label') !!}
                    </a>
                </li>
                {{--logged--}}
                @if($loginStatus)
                    <?php
                    $loginUserId = $modelUser->loginUserId();
                    ?>
                    {{--land of user--}}
                    @if(count($dataLandLicense) > 0)
                        <?php
                        $landUserId = $dataLandLicense->userId();
                        $licenseId = $dataLandLicense->licenseId();
                        ?>
                        {{--user login is owner of land--}}
                        @if($landUserId == $loginUserId)
                            <?php
                            $dataLandRequestBuild = $dataLandLicense->landRequestBuildInfoActive();
                            ?>
                            @if(count($dataLandRequestBuild) >0)
                                <li class="tf-border-top tf-border-bottom">
                                    <a class="tf_land_request_build_cancel tf-link-grey"
                                       data-request="{!! $dataLandRequestBuild->requestId() !!}"
                                       data-href="{!! route('tf.map.land.request-build.cancel') !!}"
                                       title="Cancellation of construction requirement.">
                                        cancel build
                                    </a>
                                </li>
                            @else
                                <li class="tf-border-top">
                                    <a class="tf_land_build_building_sample_get tf-link" data-land="{!! $landId !!}"
                                       data-href="{!! route('tf.map.land.build.sample.get') !!}">
                                        {!! trans('frontend_map.land_menu_build') !!}
                                    </a>
                                </li>
                                <li class="tf-border-bottom">
                                    <a class="tf_land_request_build tf-link" data-license="{!! $licenseId !!}"
                                       data-href="{!! route('tf.map.land.request-build.get') !!}">
                                        {!! trans('frontend_map.land_menu_request_build') !!}
                                    </a>
                                </li>
                            @endif
                            @if($dataLandLicense->allowInvite())
                                @if($dataLandLicense->existInvite())
                                    <li>
                                        <a class="tf-color-grey">
                                            {!! trans('frontend_map.land_menu_invited_label') !!}
                                        </a>
                                    </li>
                                @else
                                    <li>
                                        <a class="tf_land_invite_get tf-link"
                                           data-license="{!! $dataLandLicense->licenseId() !!}"
                                           data-href="{!! route('tf.map.land.invite.get') !!}">
                                            {!! trans('frontend_map.land_menu_invite_label') !!}
                                        </a>
                                    </li>
                                @endif
                            @endif
                        @endif
                    @endif
                @endif
            </ul>
        </li>
    @else
        <li>
            <a class="tf_land_menu_icon m_tf_land_menu_icon tf-color tf-margin-padding-none"
               data-href="{!! route('tf.map.land.menu.get') !!}"
               title="{!! trans('frontend_map.land_menu_setting_label') !!}">
                <i class="fa fa-bars tf-font-size-30 tf-cursor-pointer"></i>
            </a>
        </li>
    @endif

    {{--transaction status--}}
    @if($dataLandTransaction->transactionStatus->checkSaleStatus())
        <li class="tf-padding-lef-10">
            <a class="tf_land_transaction_button tf-land-transaction-button tf-link-hover-white tf-bg-hover"
               data-href="{!! route('tf.map.land.buy.get') !!}">
                {!! trans('frontend_map.button_buy') !!}
            </a>
        </li>
    @elseif($dataLandTransaction->transactionStatus->checkFreeStatus())
        <li class="tf-padding-lef-10">
            <a class="tf_land_transaction_button tf-land-transaction-button tf-link-hover-white tf-bg-hover"
               data-href="{!! route('tf.map.land.free.get') !!}">
                {!! trans('frontend_map.button_select') !!}
            </a>
        </li>
    @endif


</ul>