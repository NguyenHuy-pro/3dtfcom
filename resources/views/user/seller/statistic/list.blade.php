<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/29/2016
 * Time: 10:51 AM
 */
/*
 *
 * $modelUser
 * $dataUser
 *
 *
 */

$hFunction = new Hfunction();

#access user info
$userAccessId = $dataUser->userId();
$dateTake = $hFunction->carbonNow();

$dataSeller = $dataUser->sellerInfoOfUser();
$beginDate = $dataSeller->beginDate();
$landShare = $dataSeller->landShare();
$landShareAccess = $dataSeller->landShareAccess();
$landShareRegister = $dataSeller->landShareRegister();
$landInviteRegister = $dataSeller->landInviteRegister();
$bannerShare = $dataSeller->bannerShare();
$bannerShareAccess = $dataSeller->bannerShareAccess();
$bannerShareRegister = $dataSeller->bannerShareRegister();
$bannerInviteRegister = $dataSeller->bannerInviteRegister();
$buildingShare = $dataSeller->buildingShare();
$buildingShareAccess = $dataSeller->buildingShareAccess();
$buildingShareRegister = $dataSeller->buildingShareRegister();

//price info
$paymentPrice = $dataSellerPaymentPrice->paymentPrice();
$accessNumber = $dataSellerPaymentPrice->accessValue();
$registerNumber = $dataSellerPaymentPrice->accessValue();
?>
<div class="row">
    <div class="tf_user_seller_statistic_wrap tf-bg-white col-xs-12 col-sm-12 col-md-12 col-lg-12"
         data-href-view="{!! route('tf.user.seller.statistic.view') !!}"
         data-from="{!! $beginDate !!}"
         data-to="{!! $dateTake !!}">
        <table class="table">
            <tr>
                <td class="tf-border-top-none">
                    <em class="tf-text-under">{!! trans('frontend_user.seller_statistic_from_label') !!}:</em>
                    &nbsp; {!! $hFunction->dateFormatDMY($beginDate,'/') !!}&nbsp;&nbsp;&nbsp;
                    <em class="tf-text-under">{!! trans('frontend_user.seller_statistic_to_label') !!}: </em>
                    &nbsp; {!! $hFunction->dateFormatDMY($dateTake, '/') !!}
                </td>
            </tr>
            <tr>
                <td class="tf-border-top-none text-right">

                </td>
            </tr>

            {{--On land--}}
            <tr>
                <td class="tf-border-top-none">
                    <label class="tf-em-1-5">{!! trans('frontend_user.seller_statistic_land_title_label') !!}</label>
                    <a class="tf_seller_statistic_view tf-link pull-right" data-object="land">
                        <em>{!! trans('frontend_user.seller_statistic_detail_label') !!}</em>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="tf-border-top-none">
                    <table class="table">
                        <tr style="background-color: whitesmoke;">
                            <td>
                                {!! trans('frontend_user.seller_statistic_activity_label') !!}
                            </td>
                            <td class="text-right">
                                {!! trans('frontend_user.seller_statistic_total_label') !!}
                            </td>
                            <td class="text-right">
                                {!! trans('frontend_user.seller_statistic_pay_label') !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! trans('frontend_user.seller_statistic_share_label') !!}
                            </td>
                            <td class="text-right">
                                {!! $landShare !!}
                            </td>
                            <td class="text-right">
                                $0
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! trans('frontend_user.seller_statistic_access_label') !!}
                            </td>
                            <td class="text-right">
                                {!! $landShareAccess !!}
                            </td>
                            <td class="text-right">
                                ${!! (($landShareAccess*$paymentPrice)/$accessNumber >= 0.2 )?($landShareAccess*$paymentPrice)/$accessNumber:0 !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! trans('frontend_user.seller_statistic_share_register_label') !!}
                            </td>
                            <td class="text-right">
                                {!! $landShareRegister !!}
                            </td>
                            <td class="text-right">
                                ${!! (($landShareRegister*$paymentPrice)/$registerNumber >= 0.2 )?($landShareRegister*$paymentPrice)/$registerNumber:0 !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! trans('frontend_user.seller_statistic_invite_register_label') !!}
                            </td>
                            <td class="text-right">
                                {!! $landInviteRegister !!}
                            </td>
                            <td class="text-right">
                                ${!! (($landInviteRegister*$paymentPrice)/$registerNumber >= 0.2 )?($landInviteRegister*$paymentPrice)/$registerNumber:0 !!}
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>

            {{-- On banner--}}
            <tr>
                <td class="tf-border-top-none">
                    <label class="tf-em-1-5">{!! trans('frontend_user.seller_statistic_banner_title_label') !!}</label>
                    <a class="tf_seller_statistic_view tf-link pull-right" data-object="banner">
                        <em>{!! trans('frontend_user.seller_statistic_detail_label') !!}</em>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="tf-border-top-none">
                    <table class="table">
                        <tr style="background-color: whitesmoke;">
                            <td>
                                {!! trans('frontend_user.seller_statistic_activity_label') !!}
                            </td>
                            <td class="text-right">
                                {!! trans('frontend_user.seller_statistic_total_label') !!}
                            </td>
                            <td class="text-right">
                                {!! trans('frontend_user.seller_statistic_pay_label') !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! trans('frontend_user.seller_statistic_share_label') !!}
                            </td>
                            <td class="text-right">
                                {!! $bannerShare !!}
                            </td>
                            <td class="text-right">
                                $0
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! trans('frontend_user.seller_statistic_access_label') !!}
                            </td>
                            <td class="text-right">
                                {!! $bannerShareAccess !!}
                            </td>
                            <td class="text-right">
                                ${!! (($bannerShareAccess*$paymentPrice)/$accessNumber >= 0.2 )?($landShareRegister*$paymentPrice)/$accessNumber:0 !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! trans('frontend_user.seller_statistic_share_register_label') !!}
                            </td>
                            <td class="text-right">
                                {!! $bannerShareRegister !!}
                            </td>
                            <td class="text-right">
                                ${!! (($bannerShareRegister*$paymentPrice)/$registerNumber >= 0.2 )?($bannerShareRegister*$paymentPrice)/$registerNumber:0 !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! trans('frontend_user.seller_statistic_invite_register_label') !!}
                            </td>
                            <td class="text-right">
                                {!! $bannerInviteRegister !!}
                            </td>
                            <td class="text-right">
                                ${!! (($bannerInviteRegister*$paymentPrice)/$registerNumber >= 0.2 )?($bannerInviteRegister*$paymentPrice)/$registerNumber:0 !!}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td class="tf-border-top-none">
                    <label class="tf-em-1-5">{!! trans('frontend_user.seller_statistic_building_title_label') !!}</label>
                    <a class="tf_seller_statistic_view tf-link pull-right" data-object="building">
                        <em>{!! trans('frontend_user.seller_statistic_detail_label') !!}</em>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="tf-border-top-none">
                    <table class="table">
                        <tr style="background-color: whitesmoke;">
                            <td>
                                {!! trans('frontend_user.seller_statistic_activity_label') !!}
                            </td>
                            <td class="text-right">
                                {!! trans('frontend_user.seller_statistic_total_label') !!}
                            </td>
                            <td class="text-right">
                                {!! trans('frontend_user.seller_statistic_pay_label') !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! trans('frontend_user.seller_statistic_share_label') !!}
                            </td>
                            <td class="text-right">
                                {!! $buildingShare !!}
                            </td>
                            <td class="text-right">
                                $0
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! trans('frontend_user.seller_statistic_access_label') !!}
                            </td>
                            <td class="text-right">
                                {!! $buildingShareAccess !!}
                            </td>
                            <td class="text-right">
                                ${!! (($buildingShareAccess*$paymentPrice)/$accessNumber >= 0.2 )?($buildingShareAccess*$paymentPrice)/$accessNumber:0 !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! trans('frontend_user.seller_statistic_share_register_label') !!}
                            </td>
                            <td class="text-right">
                                {!! $buildingShareRegister !!}
                            </td>
                            <td class="text-right">
                                ${!! (($buildingShareRegister*$paymentPrice)/$registerNumber >= 0.2 )?($buildingShareRegister*$paymentPrice)/$registerNumber:0 !!}
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>

        </table>
    </div>
</div>

