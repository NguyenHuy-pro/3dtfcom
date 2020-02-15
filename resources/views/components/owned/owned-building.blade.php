<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/9/2016
 * Time: 10:42 AM
 *
 * $dataBuilding
 *
 */
$mobileDetect = new Mobile_Detect();
?>
@extends('components.owned.owned-wrap')
@section('tf_owned_content')
    @if(count($dataBuilding) > 0)
        <div class="tf_owned_building_container list-group" data-href-land="{!! route('tf.map.land.access') !!}"
             data-href-area="{!! route('tf.map.area.get') !!}">
            @foreach($dataBuilding as $itemBuilding)
                <?php
                $no = (isset($no)) ? $no + 1 : 1;
                $buildingId = $itemBuilding->buildingId();
                $landId = $itemBuilding->landLicense->landId();
                $sampleId = $itemBuilding->sampleId();
                $name = $itemBuilding->name();
                $alias = $itemBuilding->alias();

                #get project info
                $dataProject = $itemBuilding->landLicense->land->project;

                # handling max name
                $newName = (strlen($name) > 15) ? mb_substr($name, 0, 15, 'UTF-8') . "..." : $name;
                ?>
                <div class="thumbnail tf_owned_building_object tf-owned-object "
                     data-province="{!! $dataProject->provinceId() !!}"
                     data-area="{!! $dataProject->areaId() !!}" data-land="{!! $landId !!}">
                    <img class="tf_on_map tf-cursor-pointer" alt="{!! $alias !!}"
                         src="{!! $itemBuilding->buildingSample->pathImage() !!}">

                    <div class="caption">
                        <span class="tf_on_map tf-link">
                            <i class="tf-font-size-16 fa fa-map-marker"></i>
                            {!! $newName !!}
                        </span>
                    </div>
                    <a class="tf-home-page-building tf-link-green" href="{!! route('tf.building', $alias) !!}"
                       @if(!$mobileDetect->isMobile()) target="_blank" @endif title="Home page">
                        <i class="tf-font-size-16 fa fa-home"></i>
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <div class="tf-padding-top-20 col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <em class="tf-color-red">{!! trans('frontend.owned_building_notify') !!}.</em>
        </div>
    @endif
@endsection
