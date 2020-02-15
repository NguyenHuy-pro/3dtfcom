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
    @foreach($dataProjectSample as $sampleObject)
        <div class="tf_m_build_tool_build_project_object thumbnail tf-margin-bot-none"
             data-project="{!! $sampleObject->projectId() !!}">
            <img class="tf-m-build-control-sample" alt="land" src="{!! $sampleObject->pathSmallImage() !!}">

            <div class="caption">
                <a class="tf_select tf-link" data-href="{!! route('tf.m.build.map.tool.build.project.select') !!}">Select</a>
                |
                <a class="tf_view tf-link" data-href="{!! route('tf.m.build.map.tool.build.project.view') !!}">View</a>
            </div>
        </div>
    @endforeach
@endsection
