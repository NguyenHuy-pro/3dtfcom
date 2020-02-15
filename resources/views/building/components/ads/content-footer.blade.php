<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 3/16/2017
 * Time: 3:51 PM
 */
/*
 * modelUser
 * modelBuilding
 */
$adsBannerBottom = $modelBuilding->adsBannerBottom();
?>
@if(count($adsBannerBottom) > 0)
    <table class="table">
        @foreach($adsBannerBottom as $dataAdsBanner)
            <tr>
                <td class="text-center" style="padding: 0 0 5px 0;">
                    @include('ads.all-page.banner-object', compact('dataAdsBanner'),
                     [
                        'modelUser'=>$modelUser
                     ])
                </td>
            </tr>
        @endforeach
    </table>
@endif


