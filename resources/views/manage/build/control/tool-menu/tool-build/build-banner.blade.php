<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 7/30/2016
 * Time: 8:52 AM
 */
?>
@extends('manage.build.control.tool-menu.tool-build.tool-build-wrap')
@section('tf_m_build_tool_build_content')
    @foreach($dataBannerSample as $sampleObject)
        <div class="thumbnail tf-margin-bot-none">
            <img id="build-banner-{!! $sampleObject->sampleId() !!}"
                 class="tf-m-build-control-sample"
                 data-sample="{!! $sampleObject->sampleId() !!}"
                 ondragstart="tf_m_build_map.drag(event);"
                 src="{!! asset('public/main/icons/banner-icon.png') !!}" alt="land">

            <div class="caption">
                ({!! $sampleObject->size->name() !!}) px
            </div>
        </div>
    @endforeach
@endsection
