<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/13/2016
 * Time: 10:12 AM
 *
 * $modelUser
 * $dataMapAccess
 * $dataBanner
 * $dataBannerTransaction
 * $dataBannerImage
 *
 */
$mobileDetect = new Mobile_Detect();
$loginStatus = $modelUser->checkLogin();

# image of banner info
$bannerId = $dataBanner->bannerId();
?>
<ul class="nav nav-pills tf_banner_menu tf-banner-menu" role="tablist">
    @if($mobileDetect->isMobile())
        <li class="tf-margin-rig-10">
            <a class="m_tf_banner_menu_icon tf-margin-padding-none tf-color"
               data-href="{!! route('m.tf.map.banner.information.get') !!}"
               title="{!! trans('frontend_map.land_menu_setting_title') !!}">
                <i class="fa fa-bars tf-font-size-30 tf-cursor-pointer"></i>
            </a>
        </li>
    @endif
    @if(!$mobileDetect->isMobile())
        {{--help--}}
        <li class="tf-padding-rig-4">
            <a class="glyphicon glyphicon-question-sign tf-link-bold tf-banner-menu-icon"
               href="{!! route('tf.help','advertising-banner/activities') !!}" target="_blank"
               title="{!! trans('frontend_map.banner_menu_help_title') !!}"></a>
        </li>
    @endif

    {{--transaction status --}}
    @if($dataBannerTransaction->transactionStatus->checkSaleStatus())
        <li class="tf-padding-rig-4">
            <a class="tf_banner_transaction_button tf-banner-transaction-button tf-link-hover-white tf-bg-hover"
               data-href="{!! route('tf.map.banner.buy.get') !!}">
                {!! trans('frontend_map.button_buy') !!}
            </a>
        </li>
    @elseif($dataBannerTransaction->transactionStatus->checkFreeStatus())
        <li class="tf-padding-rig-4">
            <a class="tf_banner_transaction_button tf-banner-transaction-button tf-link-hover-white tf-bg-hover"
               data-href="{!! route('tf.map.banner.free.get') !!}">
                {!! trans('frontend_map.button_select') !!}
            </a>
        </li>
    @endif

    @if(!$mobileDetect->isMobile())
        {{--share--}}
        <li class="tf-padding-rig-4">
            <a class="tf_banner_share_get fa fa-share-alt tf-link-bold tf-banner-menu-icon"
               data-banner="{!! $bannerId !!}" data-href="{!! route('tf.map.banner.share.get') !!}"
               title="{!! trans('frontend_map.banner_menu_share_title') !!}"></a>
        </li>
        {{--logged--}}
        @if($loginStatus)
            <?php
            $loginUserId = $modelUser->loginUserId();
            ?>
            {{--user login is owner of banner--}}
            @if($dataBanner->checkBannerOfUser($loginUserId, $bannerId))
                {{--invite--}}
                <li class="tf-padding-rig-4">
                    <a class="tf_banner_invite_get tf-banner-menu-icon fa fa-gift tf-link-bold"
                       data-banner="{!! $bannerId !!}" data-href="{!! route('tf.map.banner.invite.get') !!}"
                       title="{!! trans('frontend_map.banner_menu_invite_title') !!}"></a>
                </li>

                <li>
                    <a class="tf-banner-menu-icon dropdown-toggle glyphicon glyphicon-cog tf-link-bold"
                       data-toggle="dropdown" title="{!! trans('frontend_map.banner_menu_setting_title') !!}"></a>
                    <ul class="dropdown-menu tf-padding-none tf-box-shadow">
                        @if(count($dataBannerImage) == 0)
                            {{-- not exist image of banner--}}
                            <li>
                                <a class="tf_banner_image_add_get" data-banner="{!! $bannerId !!}"
                                   data-href="{!! route('tf.map.banner.image.add.get') !!}">
                                    {!! trans('frontend_map.banner_menu_add_image') !!}
                                </a>
                            </li>
                        @else
                            <li>
                                <a class="tf_banner_image_edit_get" data-banner="{!! $bannerId !!}"
                                   data-href="{!! route('tf.map.banner.image.edit.get') !!}">
                                    {!! trans('frontend_map.banner_menu_edit_image') !!}
                                </a>
                            </li>
                            <li>
                                <a class="tf_banner_image_delete" data-banner="{!! $bannerId !!}"
                                   data-href="{!! route('tf.map.banner.image.delete') !!}">
                                    {!! trans('frontend_map.banner_menu_delete') !!}
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @else
                {{--report--}}
                @if(count($dataBannerImage) > 0)
                    <li>
                        <a class="tf-banner-menu-icon dropdown-toggle glyphicon glyphicon-cog tf-link-bold "
                           data-toggle="dropdown" title="{!! trans('frontend_map.banner_menu_report_image') !!}"></a>
                        <ul class="dropdown-menu tf-padding-none tf-box-shadow">
                            <li>
                                <a class="tf_banner_image_report_get" data-image="{!! $dataBannerImage->imageId() !!}"
                                   data-href="{!! route('tf.map.banner.image.report.get') !!}">
                                    {!! trans('frontend_map.banner_menu_report_image') !!}
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            @endif
        @endif
    @endif
</ul>
