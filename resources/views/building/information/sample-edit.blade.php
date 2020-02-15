<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/23/2016
 * Time: 10:31 AM
 */
$buildingId = $dataSelectInfo['buildingId'];
$privateStatus = $dataSelectInfo['privateStatus'];
?>
@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    <div id="tf_building_sample_edit"
         class="tf_building_sample_edit  panel panel-default tf-border-none tf-padding-none tf-margin-bot-none "
         data-building="{!! $buildingId !!}" data-private-status="{!! $privateStatus !!}"
         data-href-select="{!! route('tf.building.info.sample.edit.select') !!}">
        <div id="tf_building_sample_edit_header" class="panel-heading  tf-border-none tf-padding-none tf-bg">
            <ul class="nav nav-pills ">
                <li>
                    <a class="tf_select_sample_menu @if($privateStatus == 0) tf-link-red-bold @else tf-link-white @endif"
                       data-href="{!! route('tf.building.info.sample.edit.get',"$buildingId/0") !!}">
                        {!! trans('frontend_building.info_setting_select_sample_system') !!}
                    </a>
                </li>
                <li>
                    <a class="tf_select_sample_menu @if($privateStatus == 1) tf-link-red-bold @else tf-link-white @endif"
                       data-href="{!! route('tf.building.info.sample.edit.get',"$buildingId/1") !!}">
                        {!! trans('frontend_building.info_setting_select_sample_private') !!}
                    </a>
                </li>
            </ul>
        </div>
        <div id="tf_building_sample_edit_body" class="panel-body tf-padding-20 tf-overflow-auto">
            <div class="row">
                {{--exist sample--}}
                @if(count($dataBuildingSample) > 0)
                    @foreach($dataBuildingSample as $itemSample)
                        <div class="tf-margin-none col-xs-4 col-sm-4 col-md-3 col-lg-3">
                            <div class="thumbnail">
                                <img class="tf_sample_img tf-cursor-pointer"
                                     data-sample="{!! $itemSample->sampleId() !!}"
                                     src="{!! $itemSample->pathImage() !!}" title="click to select" alt="sample">
                                <div class="caption">
                                    <span class="tf-color-red">
                                    @if($privateStatus == 1)
                                            0
                                        @else
                                            {!! $itemSample->price() !!}
                                        @endif
                                    </span> <em>Point</em>
                                </div>
                            </div>
                        </div>
                    @endforeach

                @else
                    <div class=" text-center tf-color-red col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        {!! trans('frontend_building.info_setting_select_sample_notify_null') !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            headerTop = $('#tf_building_sample_edit_header').outerHeight();
            $('#tf_building_sample_edit_body').css('height', windowHeight - headerTop - 80);
        });
    </script>
@endsection
