<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/27/2016
 * Time: 10:15 AM
 *
 *
 */

/*
 * modelUser
 * sellerAccess
 */
$modelMobile = new Mobile_Detect();
$object = $dataSellerAccess['object'];
?>
<div class="row">
    <div class="tf-bg tf-padding-none col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <ul class="nav nav-tabs" role="tablist">
            <li class="@if($object == 'guide') active @endif">
                <a class="@if($object == 'guide') tf-link-bold @else tf-link-white @endif"
                   href="{!! route('tf.seller.guide.get') !!}">
                    {!! trans('frontend_seller.menu_label_guide') !!}
                </a>
            </li>
            <li class="@if($object == 'signUp') active @endif">
                <a class="@if($object == 'signUp') tf-link-bold @else tf-link-white @endif"
                   href="{!! route('tf.seller.sign-up.get') !!}">
                    @if(!$modelMobile->isMobile())
                    {!! trans('frontend_seller.menu_label_sign_up') !!}
                    @else
                        {!! trans('frontend_seller.menu_m_label_sign_up') !!}
                    @endif
                </a>
            </li>

            <li class="@if($object == 'payment') active @endif">
                <a class="@if($object == 'payment') tf-link-bold @else tf-link-white @endif"
                   href="{!! route('tf.seller.payment.get') !!}">
                    @if(!$modelMobile->isMobile())
                    {!! trans('frontend_seller.menu_label_payment') !!}
                    @else
                        {!! trans('frontend_seller.menu_m_label_payment') !!}
                    @endif
                </a>
            </li>
        </ul>

    </div>
</div>
