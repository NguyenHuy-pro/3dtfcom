<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/21/2017
 * Time: 1:13 PM
 */

/*
 * modelUser
 * modelSellerGuide
 */
$dataSellerGuide = $modelSellerGuide->infoOfLand();
?>
<table class="table">
    @if(count($dataSellerGuide) > 0)
        @foreach($dataSellerGuide as $sellerGuide)
            <tr>
                <td class="tf-border-none">
                    <label>* {!! $sellerGuide->name() !!}</label>
                </td>
            </tr>
            <tr>
                <td class="tf-border-none">
                    {!! $sellerGuide->content() !!}
                </td>
            </tr>
            @if(!empty($sellerGuide->video()))
                <tr>
                    <td class="tf-border-none text-center">
                        <em>{!! trans('frontend_seller.guide_land_video_label') !!}</em>
                        <br/>

                        <div class="row">
                            <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
                                <iframe width="100%" height="500" src="//www.youtube.com/embed/{!! $sellerGuide->video() !!}?autoplay=0"
                                        frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>

                    </td>
                </tr>
            @endif
        @endforeach
    @else
        <tr>
            <td class="tf-border-none">
                <em>{!! trans('frontend_seller.guide_land_notify_null') !!}</em>
            </td>
        </tr>
    @endif

</table>
