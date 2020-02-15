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
    @foreach($dataProjectBackground as $backgroundObject)
        <div class="tf_m_build_tool_build_background_object thumbnail tf-margin-bot-none"
             data-background="{!! $backgroundObject->backgroundId() !!}">
            <img class="tf-m-build-control-sample" alt="background" src="{!! $backgroundObject->pathSmallImage() !!}">

            <div class="caption">
                <a class="tf_view tf-link" data-href="{!! route('tf.m.build.map.tool.build.project-background.view') !!}">View</a>
                |
                <a class="tf_select tf-link" data-href="{!! route('tf.m.build.map.tool.build.project-background.select') !!}">Select</a>

            </div>
        </div>
    @endforeach
@endsection
