<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/23/2016
 * Time: 10:31 AM
 */
#$modelBuildingSample = new \App\Models\Manage\Content\Sample\Building\TfBuildingSample();

$buildingId = $dataSelectInfo['buildingId'];
$privateStatus = $dataSelectInfo['privateStatus'];
?>
@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    <div id="tf_building_select_sample"
         class="tf_building_select_sample tf-select-building-sample panel panel-default tf-border-none tf-padding-none tf-margin-bot-none "
         data-building="{!! $buildingId !!}" data-private-status="{!! $privateStatus !!}"
         data-href-check="{!! route('tf.map.building.sample.edit.check-point') !!}"
         data-href-select="{!! route('tf.map.building.sample.edit.select') !!}">
        <div id="tf_building_select_sample_header" class="panel-heading  tf-border-none ">
            <div class="row tf-bg">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="nav nav-pills ">
                        <li>
                            <a class="tf_select_sample_menu @if($privateStatus == 0) tf-link-red-bold @else tf-link-white @endif"
                               data-href="{!! route('tf.map.building.sample.edit.get',"$buildingId/0") !!}">
                                {!! trans('frontend_map.building_info_select_sample_system') !!}
                            </a>
                        </li>
                        <li>
                            <a class="tf_select_sample_menu @if($privateStatus == 1) tf-link-red-bold @else tf-link-white @endif"
                               data-href="{!! route('tf.map.building.sample.edit.get',"$buildingId/1") !!}">
                                {!! trans('frontend_map.building_info_select_sample_private') !!}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="tf_building_select_sample_body" class="panel-body tf-padding-20">
            <div class="row">
                {{--exist sample--}}
                @if(count($dataBuildingSample) > 0)
                    @foreach($dataBuildingSample as $itemSample)
                        <?php
                        $point = ($privateStatus == 1) ? 0 : $itemSample->price();
                        ?>
                        <div class="tf-margin-none col-xs-4 col-sm-4 col-md-3 col-lg-3 ">
                            <div class="thumbnail">
                                <img class="tf_building_select_sample_img tf-cursor-pointer"
                                     data-price="{!! $point !!}"
                                     data-sample="{!! $itemSample->sampleId() !!}"
                                     data-private-status="{!! $privateStatus !!}"
                                     src="{!! $itemSample->pathImage() !!}"
                                     title="click to select" alt="sample">

                                <div class="caption">
                                    <span class="tf-color-red">{!! $point !!}</span> <em>Point</em>
                                </div>
                            </div>
                        </div>
                    @endforeach

                @else
                    <div class="tf-color-red col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        {!! trans('frontend_map.building_edit_sample_notify_null') !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            headerTop = $('#tf_building_select_sample_header').outerHeight();
            $('#tf_building_select_sample_body').css('height', windowHeight - headerTop - 80);
        });
    </script>
@endsection
