<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/30/2016
 * Time: 10:14 AM
 *
 * $dataBuilding
 */
?>
@extends('components.container.top.container-4')
@section('tf_main_container_top_content')
    <div id="tf_building_post_select_intro" class="panel panel-default tf-border-none tf-padding-none tf-margin-bot-none ">
        <div id="tf_building_post_select_intro_header" class="panel-heading tf-bg tf-color-white tf-border-none ">
            <i class="tf-font-size-16 glyphicon glyphicon-home"></i>
            &nbsp;
            {!! trans('frontend_building.posts_select_intro_building_title') !!}
        </div>
        <div id="tf_building_post_select_intro_body" class="panel-body tf-overflow-auto">
            <div class="list-group">
                @if(count($dataBuilding) > 0)
                    @foreach($dataBuilding as $objectBuilding)
                        <?php
                        $buildingId = $objectBuilding->buildingId();
                        $sampleId = $objectBuilding->sampleId();
                        ?>
                        <a class="tf_intro_building tf-cursor-pointer list-group-item" data-building="{!! $buildingId !!}">
                            <img class="tf_sample_image" style="max-width: 96px; max-height: 96px;" alt="{!! $objectBuilding->alias() !!}"
                                 src="{!! $objectBuilding->buildingSample->pathImage() !!}">
                            {!! $objectBuilding->name() !!}
                        </a>
                    @endforeach
                @else
                    <a class="list-group-item tf-color-red">
                        {!! trans('frontend_building.posts_select_intro_building_notify') !!}
                    </a>
                @endif

            </div>
        </div>
        <div id="tf_building_post_select_intro_footer" class="panel panel-footer text-center tf-margin-bot-none ">
            <a class="tf_main_container_top_close btn btn-primary tf-link">
                {!! trans('frontend.button_close') !!}
            </a>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                var headerHeight = $('#tf_building_post_select_intro_header').outerHeight();
                var footerHeight = $('#tf_building_post_select_intro_footer').outerHeight();
                $('#tf_building_post_select_intro_body').css('height', windowHeight - headerHeight - footerHeight - 80);
            });
        </script>
    </div>
@endsection