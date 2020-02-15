<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/15/2016
 * Time: 11:11 AM
 *
 *
 * $dataBannerImage
 *
 */

# info of image
$imageId = $dataBannerImage->imageId();
$website = $dataBannerImage->website();

?>
<a id="tf_banner_image_{!! $imageId !!}" class="tf_banner_image tf-banner-image tf-link-full"
   data-image="{!! $imageId !!}" target="_blank"
   data-href-detail="{!! route('tf.map.banner.image.detail.get') !!}"
   data-href-visit="{!! route('tf.map.banner.image.visit.get') !!}">
    <img alt="banner-image" src="{!! $dataBannerImage->pathSmallImage() !!}">
</a>
