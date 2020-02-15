<?php
/*
 * $modelUser
 * $dataBuilding
 * $recentBannerImageList
 *
 */
$hFunction = new Hfunction();
?>
<table class="table tf-building-news-banner-image">
    @foreach($recentBannerImageList as $recentBannerImage)
        <tr>
            <td class="text-center">
                <a class="tf-link" href="{!! route('tf.map.banner.access',$recentBannerImage->bannerId() ) !!}"
                   @if(!$hFunction->isHandset()) target="_blank" @endif>
                    <img src="{!! $recentBannerImage->pathSmallImage() !!}">
                </a>
            </td>
        </tr>
    @endforeach
</table>