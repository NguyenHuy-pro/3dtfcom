<?php
/**
 *
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/29/2016
 * Time: 1:31 PM
 *
 *
 * $modelUser
 *
 *
 */
$hFunction = new Hfunction();
?>
<div id="tf_user_seller_payment_detail_more" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <ul class="nav nav-tabs" role="tablist">
        <li @if($object == 'land') class=" active" @endif >
            <a class="tf_payment_detail_more tf-link" href="#" data-object="land">
                {!! trans('frontend_user.seller_payment_view_detail_menu_land') !!}
            </a>
        </li>
        <li @if($object == 'banner') class=" active" @endif >
            <a class="tf_payment_detail_more tf-link" href="#" data-object="banner">
                {!! trans('frontend_user.seller_payment_view_detail_menu_banner') !!}
            </a>
        </li>
        <li @if($object == 'building') class=" active" @endif >
            <a class="tf_payment_detail_more tf-link" href="#" data-object="building">
                {!! trans('frontend_user.seller_payment_view_detail_menu_building') !!}
            </a>
        </li>
    </ul>
    @if($object == 'land')
        <table class="table table-hover">
            <tr>
                <th class="tf-border-none">
                    {!! trans('frontend_user.seller_payment_view_detail_code_label') !!}
                </th>
                <th class="text-center tf-border-none">
                    {!! trans('frontend_user.seller_payment_view_detail_access_label') !!}
                </th>
                <th class="text-center tf-border-none">
                    {!! trans('frontend_user.seller_payment_view_detail_register_label') !!}
                </th>
                <th class="tf-border-none text-right">
                    {!! trans('frontend_user.seller_payment_view_detail_date_label') !!}
                </th>
            </tr>
            @if(count($dataLandShare) > 0)
                @foreach($dataLandShare as $landShare)
                    <tr>
                        <td>
                            {!! $landShare->shareCode() !!}
                        </td>
                        <td class="text-center">
                            {!! $landShare->totalView() !!}
                        </td>
                        <td class="text-center">
                            {!! $landShare->totalViewRegister() !!}
                        </td>
                        <td class="text-right">
                            {!! $landShare->createdAt() !!}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td>
                        {!! trans('frontend_user.seller_payment_view_detail_null') !!}
                    </td>
                </tr>
            @endif
        </table>
    @elseif($object=='banner')
        <table class="table table-hover">
            <tr>
                <th class="tf-border-none">
                    {!! trans('frontend_user.seller_payment_view_detail_code_label') !!}
                </th>
                <th class="text-center tf-border-none">
                    {!! trans('frontend_user.seller_payment_view_detail_access_label') !!}
                </th>
                <th class="text-center tf-border-none">
                    {!! trans('frontend_user.seller_payment_view_detail_register_label') !!}
                </th>
                <th class="tf-border-none text-right">
                    {!! trans('frontend_user.seller_payment_view_detail_date_label') !!}
                </th>
            </tr>
            @if(count($dataBannerShare) > 0)
                @foreach($dataBannerShare as $bannerShare)
                    <tr>
                        <td>
                            {!! $bannerShare->shareCode() !!}
                        </td>
                        <td class="text-center">
                            {!! $bannerShare->totalView() !!}
                        </td>
                        <td class="text-center">
                            {!! $bannerShare->totalViewRegister() !!}
                        </td>
                        <td class="text-right">
                            {!! $bannerShare->createdAt() !!}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4">
                        {!! trans('frontend_user.seller_payment_view_detail_null') !!}
                    </td>
                </tr>
            @endif
        </table>
    @elseif($object =="building")
        <table class="table table-hover">
            <tr>
                <th class="tf-border-none">
                    {!! trans('frontend_user.seller_payment_view_detail_code_label') !!}
                </th>
                <th class="text-center tf-border-none">
                    {!! trans('frontend_user.seller_payment_view_detail_access_label') !!}
                </th>
                <th class="text-center tf-border-none">
                    {!! trans('frontend_user.seller_payment_view_detail_register_label') !!}
                </th>
                <th class="tf-border-none text-right">
                    {!! trans('frontend_user.seller_payment_view_detail_date_label') !!}
                </th>
            </tr>
            @if(count($dataBuildingShare) > 0)
                @foreach($dataBuildingShare as $buildingShare)
                    <tr>
                        <td>
                            {!! $buildingShare->shareCode() !!}
                        </td>
                        <td class="text-center">
                            {!! $buildingShare->totalView() !!}
                        </td>
                        <td class="text-center">
                            {!! $buildingShare->totalViewRegister() !!}
                        </td>
                        <td class="text-right">
                            {!! $buildingShare->createdAt() !!}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4">
                        {!! trans('frontend_user.seller_payment_view_detail_null') !!}
                    </td>
                </tr>
            @endif
        </table>
    @endif
</div>
