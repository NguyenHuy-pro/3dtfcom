<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/9/2016
 * Time: 10:43 AM
 *
 * $dataBanner
 *
 */
?>
@extends('components.owned.owned-wrap')
@section('tf_owned_content')
    @if(count($dataBanner) > 0)
        <ul class="tf_owned_banner_container list-group" data-href-banner="{!! route('tf.map.banner.access') !!}"
             data-href-area="{!! route('tf.map.area.get') !!}">
            @foreach($dataBanner as $itemBanner)
                <?php
                $no = (isset($no)) ? $no + 1 : 1;
                $bannerId = $itemBanner->bannerId();
                $projectId = $itemBanner->projectId();
                $dataProject = $itemBanner->project;

                $dataBannerImage = $itemBanner->imageInfo();
                ?>
                <li class="list-group-item tf-padding-bot-10 tf-padding-top-10">
                    <b>{!! $no !!}.</b>&nbsp;
                    <a class="tf_owned_banner_name tf-link text-center" data-province="{!! $dataProject->provinceId() !!}"
                          data-area="{!! $dataProject->areaId() !!}" data-banner="{!! $bannerId !!}">
                        @if(count($dataBannerImage) > 0)
                            <img style="max-width: 64px; max-height: 64px;" alt="image" src="{!! $dataBannerImage->pathSmallImage() !!}">
                        @else
                            <img style="max-width: 96px; max-height: 64px;" alt="banner" src="{!! asset('public/main/icons/banner-icon.png') !!}">
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <div class="tf-padding-top-20 col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <em class="tf-color-red">{!! trans('frontend.owned_banner_notify') !!}.</em>
        </div>
    @endif
@endsection
