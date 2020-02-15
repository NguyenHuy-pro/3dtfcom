<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/14/2017
 * Time: 11:51 AM
 */
/*
 * dataBuilding
 */
$hFunction = new Hfunction();
$shortDescription = $dataBuilding->shortDescription();
$contentShow = (strlen($shortDescription) > 150) ? $hFunction->cutString($shortDescription, 150, '...') : $shortDescription;
?>
<div class="row tf_building_short_description tf-building-short-description tf-bg-white">
    <div class="tf_content_show tf-content col-xs-12 col-sm-12 col-md-12 col-lg-12">
        {!! $contentShow !!}
    </div>
    @if(strlen($shortDescription) > 150)
        <div class="tf_content_full tf-content tf-display-none col-xs-12 col-sm-12 col-md-12 col-lg-12">
            {!! $shortDescription !!}
        </div>
    @endif
    @if(strlen($shortDescription) > 150)
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="text-center tf-padding-5 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <a class="tf_view_more tf-link">
                    View More
                </a>
                <a class="tf_view_more_hide tf-link tf-display-none">
                    Hide
                </a>
            </div>
        </div>
    @endif
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-top: solid 1px #d7d7d7;"></div>
    </div>
</div>
