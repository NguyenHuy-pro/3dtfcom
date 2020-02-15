<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/9/2016
 * Time: 10:43 AM
 */
/*
 *
 * dataLandLicense
 */

?>
@extends('components.owned.owned-wrap')
@section('tf_owned_content')
    @if(count($dataLandLicense) > 0)
        <ul class="tf_owned_land_container list-group" data-href-land="{!! route('tf.map.land.access') !!}"
            data-href-area="{!! route('tf.map.area.get') !!}">
            @foreach($dataLandLicense as $landLicense)
                <?php
                $landId = $landLicense->landId();
                $dataProject = $landLicense->land->project;
                ?>
                @if(!$landLicense->checkExistBuilding())
                    <?php
                    $no = (isset($no)) ? $no + 1 : 1;
                    ?>
                    <li class="list-group-item tf-padding-bot-10 tf-padding-top-10">
                        <b>{!! $no !!}.</b> &nbsp;
                        <a class="tf_owned_land_name tf-link tex-center"
                           data-province="{!! $dataProject->provinceId() !!}"
                           data-area="{!! $dataProject->areaId() !!}" data-land="{!! $landId !!}">
                            <img style="max-width: 64px; max-height: 64px;" alt="land"
                                 src="{!! asset('public/main/icons/my-land.png') !!}">
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    @else
        <div class="tf-padding-top-20 col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <em class="tf-color-red">{!! trans('frontend.owned_land_notify') !!}</em>
        </div>
    @endif
@endsection
