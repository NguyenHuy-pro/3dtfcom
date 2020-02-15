<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/29/2016
 * Time: 1:31 PM
 *
 * modelAdsBanner
 * dataAdsBanner
 *
 */
//banner info
$accessBannerId = $dataAdsBanner->bannerId();
$pageId = $dataAdsBanner->pageId();
//right banner
$dataAdsBannerRight = $modelAdsBanner->bannerOfPageAndRightPosition($pageId);

$dataAdsBannerBottom = $modelAdsBanner->bannerOfPageAndBottomPosition($pageId);
?>
@extends('components.container.contain-action-8')
@section('tf_main_action_content')
    <table class="table tf-height-full tf_action_height_fix tf-margin-padding-none ">
        <tr>
            <td class="tf-padding-top-20">
                <div class="col-xs-12 col-sm-10 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                             style="height: 300px; background-color: whitesmoke;;">
                            <em class="tf-color-grey">
                                <br>
                                ---------- --------- ---------- ----------- ------ -------------- ---------- ------- ----- -------
                                ----- ---- ----- ------ ----- ---- ------ --------- ------ -------- ---- -------- --------- ----------
                                ------ --- ------- ----- ----- --------- ------ -------- ----- ---- ---- ---------- ------ ----- -----
                            </em>
                        </div>
                        @if(count($dataAdsBannerBottom) > 0)
                            @foreach($dataAdsBannerBottom as $bannerObject)
                                <div class="@if($accessBannerId == $bannerObject->bannerId()) tf-ads-banner-view-object-selected @else tf-ads-banner-view-object @endif tf-font-border-yellow text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    {!! $bannerObject->name() !!}
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        @if(count($dataAdsBannerRight) > 0)
                            @foreach($dataAdsBannerRight as $bannerObject)
                                <div class="@if($accessBannerId == $bannerObject->bannerId()) tf-ads-banner-view-object-selected @else tf-ads-banner-view-object @endif tf-font-border-yellow text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    {!! $bannerObject->name() !!}
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </td>
        </tr>
    </table>
@endsection
