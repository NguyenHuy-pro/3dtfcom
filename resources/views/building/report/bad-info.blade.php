<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/30/2016
 * Time: 10:14 AM
 *
 * dataBuildingPost
 * dataBadInfo
 */
?>
@extends('components.container.contain-action-4')
@section('tf_main_action_content')
    <form id="tf_building_report_info" class="panel panel-default tf-border-none tf-padding-none tf-margin-bot-none "
          name="tf_building_report_info" method="post"
          action="{!! route('tf.building.report.bad-info.post') !!}">
        <div id="tf_building_report_header" class="panel-heading tf-bg tf-color-white tf-border-none ">
            <i class="tf-font-size-16 glyphicon glyphicon-th-list"></i>&nbsp;
            {!! trans('frontend_building.post_report_title') !!}
        </div>
        <div id="tf_building_report_body" class="panel-body tf-overflow-auto">
            <ul class="list-group">
                @if(count($dataBadInfo) > 0)
                    @foreach($dataBadInfo as $badInfo)
                        <li class="list-group-item tf-border-none tf-padding-bot-none">
                            <div class="radio">
                                <label>
                                    <input class="tf_bad_info" type="radio" name="badInfo" value="{!! $badInfo->badInfoId() !!}">
                                    {!! $badInfo->name() !!}
                                </label>
                            </div>
                        </li>
                    @endforeach
                @endif

            </ul>
        </div>
        <div id="tf_building_report_footer" class="panel panel-footer text-center tf-margin-bot-none ">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <input type="hidden" name="building" value="{!! $dataBuilding->buildingId() !!}">
            <a class="tf_send btn btn-primary tf-link">
                {!! trans('frontend.button_send') !!}
            </a>

            <a class="tf_main_contain_action_close btn btn-default tf-link">
                {!! trans('frontend.button_close') !!}
            </a>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                var headerHeight = $('#tf_building_report_header').outerHeight();
                var footerHeight = $('#tf_building_report_footer').outerHeight();
                $('#tf_building_report_body').css('height', windowHeight - headerHeight - footerHeight - 80);
            });
        </script>
    </form>
@endsection