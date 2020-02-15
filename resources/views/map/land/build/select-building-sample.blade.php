<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/23/2016
 * Time: 10:31 AM
 *
 * $dataSelectInfo
 * $dataBuildingSample
 * $modelBusinessType
 *
 */

$landId = $dataSelectInfo['landId'];
$privateStatus = $dataSelectInfo['privateStatus'];
$businessTypeId = $dataSelectInfo['businessTypeId'];
?>
@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    <div id="tf_select_building_sample"
         class="tf_select_building_sample tf-select-building-sample panel panel-default tf-border-none tf-padding-none tf-margin-bot-none "
         data-land="{!! $landId !!}"
         data-private-status="{!! $privateStatus !!}"
         data-href-filter="{!! route('tf.map.land.build.sample.get') !!}"
         data-href-add="{!! route('tf.map.land.building.add.get') !!}">
        <div id="tf_select_building_sample_header" class="panel-heading  tf-border-none ">
            <div class="row tf-bg">
                <div class="col-xs-8 col-sm-10 col-md-10 col-lg-10">
                    <ul class="nav nav-pills ">
                        <li>
                            <a class="tf_select_building_sample_private_filter @if($privateStatus == 0) tf-link-red-bold @else tf-link-white @endif"
                               data-private="0">
                                {!! trans('frontend_map.land_build_select_sample_system') !!}
                            </a>
                        </li>
                        <li>
                            <a class="tf_select_building_sample_private_filter @if($privateStatus == 1) tf-link-red-bold @else tf-link-white @endif"
                               data-private="1">
                                {!! trans('frontend_map.land_build_select_sample_private') !!}
                            </a>
                        </li>
                    </ul>

                </div>
                <div class="tf-line-height-30 text-right col-xs-4 col-sm-2 col-md-2 col-lg-2 ">
                    <span class="tf_main_contain_action_close glyphicon glyphicon-remove tf-margin-4 tf-link-red"></span>
                </div>
            </div>
            <div class="row">
                <div class="tf-line-height-30 text-right tf-padding-right-10 col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                    <em class="pull-left tf-margin-lef-10">({!! trans('frontend_map.land_build_select_sample_notice') !!})</em>
                    <select id="tf_select_building_sample_business">
                        <option value="0">{!! trans('frontend_map.land_build_select_business_label') !!}</option>
                        {!! $modelBusinessType->getOption($businessTypeId) !!}
                    </select>
                </div>
            </div>
        </div>
        <div id="tf_select_building_sample_body" class="panel-body tf-padding-20">
            <div class="row">
                {{--exist sample--}}
                @if(count($dataBuildingSample) > 0)
                    @foreach($dataBuildingSample as $itemSample)
                        <div class="tf-margin-none col-xs-6 col-sm-4 col-md-3 col-lg-3 ">
                            <div class="thumbnail">
                                <img class="tf_select_building_sample_image tf-cursor-pointer"
                                     data-sample="{!! $itemSample->sampleId() !!}"
                                     src="{!! $itemSample->pathImage() !!}"
                                     title="click to select" alt="sample">

                                <div class="caption">
                                    <span class="tf-color-red">{!! $itemSample->price() !!}</span> <em>Point</em>
                                </div>
                            </div>
                        </div>
                    @endforeach

                @else
                    <div class="text-center tf-color-red col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        {!! trans('frontend_map.label_none') !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            headerTop = $('#tf_select_building_sample_header').outerHeight();
            $('#tf_select_building_sample_body').css('height', windowHeight - headerTop - 80);
        });
    </script>
@endsection
