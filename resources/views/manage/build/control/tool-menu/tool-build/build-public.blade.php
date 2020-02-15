<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 7/30/2016
 * Time: 3:18 PM
 */
?>
@extends('manage.build.control.tool-menu.tool-build.tool-build-wrap')
@section('tf_m_build_tool_build_content')
    @if(count($dataPublicSample) > 0)
        @foreach($dataPublicSample as $itemSample)
            <div class="thumbnail tf-margin-bot-none">
                <img id="build-public-{!! $itemSample->sampleId() !!}"
                     class=" tf_m_build_control_sample tf-m-build-control-sample"
                     data-sample="{!! $itemSample->sampleId() !!}"
                     ondragstart="tf_m_build_map.drag(event);"
                     src="{!! $itemSample->pathImage() !!}" alt="public">

                <div class="caption">
                    ({!! $itemSample->size->name() !!}) px
                </div>
            </div>
        @endforeach
    @else
        <div class="thumbnail tf-margin-bot-none tf-color-red">
            not found
        </div>
    @endif
@endsection
