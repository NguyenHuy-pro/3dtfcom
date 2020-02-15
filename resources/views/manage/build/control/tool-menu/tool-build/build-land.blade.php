<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 7/25/2016
 * Time: 9:52 AM
 */
?>
@extends('manage.build.control.tool-menu.tool-build.tool-build-wrap')
@section('tf_m_build_tool_build_content')
    @foreach($dataSize as $itemSize)
        <div class="thumbnail tf-margin-bot-none">
            <img id="build-land-{!! $itemSize->sizeId() !!}" class="tf_m_build_control_sample tf-m-build-control-sample"
                 data-size="{!! $itemSize->sizeId() !!}"
                 ondragstart="tf_m_build_map.drag(event);"
                 src="{!! asset('public/main/icons/icon-land.gif') !!}" alt="land">

            <div class="caption">
                ({!! $itemSize->width() !!} x {!! $itemSize->height() !!})px
            </div>
        </div>
    @endforeach
@endsection
