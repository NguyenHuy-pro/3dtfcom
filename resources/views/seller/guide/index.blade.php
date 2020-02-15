<?php
/*
 * modelUser
 * modelSellerGuide
 * dataSellerAccess
 */

$guideObject = $dataSellerAccess['guideObject'];
?>

@extends('seller.index')
@section('titlePage')
    {!! trans('frontend_seller.title_page_guide') !!}
@endsection

@section('seller_menu')
    @include('seller.components.menu.menu', ['dataSellerAccess' => $dataSellerAccess])
@endsection

@section('seller_content')
    <div class="row">
        <div class="tf-padding-top-30 col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <ul class="nav nav-tabs nav-justified" role="tablist">
                <li @if($guideObject == 'banner') class="active" @endif>
                    <a class="@if($guideObject == 'banner') tf-link-red @else tf-link @endif"
                       href="{!! route('tf.seller.guide.get','banner') !!}">
                        {!! trans('frontend_seller.guide_menu_banner_label') !!}
                    </a>
                </li>
                <li @if($guideObject == 'building') class="active" @endif>
                    <a class="@if($guideObject == 'building') tf-link-red @else tf-link @endif"
                       href="{!! route('tf.seller.guide.get','building') !!}">
                        {!! trans('frontend_seller.guide_menu_building_label') !!}
                    </a>
                </li>
                <li @if($guideObject == 'land') class="active" @endif>
                    <a class="@if($guideObject == 'land') tf-link-red @else tf-link @endif"
                       href="{!! route('tf.seller.guide.get','land') !!}">
                        {!! trans('frontend_seller.guide_menu_land_label') !!}
                    </a>
                </li>
            </ul>
        </div>
        <div class="tf-padding-top-30 col-xs-12 col-sm-12 col-md-12 col-lg-12">
            @if($guideObject == 'building')
                @include('seller.guide.from-building', ['modelUser' => $modelUser, 'modelSellerGuide'=>$modelSellerGuide])

            @elseif($guideObject == 'land')
                @include('seller.guide.from-land', ['modelUser' => $modelUser, 'modelSellerGuide'=>$modelSellerGuide])
            @else
                @include('seller.guide.from-banner', ['modelUser' => $modelUser, 'modelSellerGuide'=>$modelSellerGuide])
            @endif
        </div>
    </div>
@endsection