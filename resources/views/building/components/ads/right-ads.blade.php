<?php
/*
 * modelUser
 * modelBuilding
 */
$getAdsBanner = $modelBuilding->adsBannerRight();
?>
@if(count($getAdsBanner) > 0)
    <table class="table tf-bg-none">
        @foreach($getAdsBanner as $dataAdsBanner)
            <tr>
                <td style="padding: 0 0 5px 0; border: none;">
                    @include('ads.all-page.banner-object', compact('dataAdsBanner'),
                     [
                        'modelUser'=>$modelUser
                     ])
                </td>
            </tr>
        @endforeach
    </table>
@endif