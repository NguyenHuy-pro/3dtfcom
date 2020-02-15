<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 7/30/2016
 * Time: 10:29 AM
 */

$hFunction = new Hfunction();
?>
@extends('manage.build.components.contain-action-10')
@section('tf_m_build_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Sample project
            <button class="btn btn-primary btn-xs tf_m_build_contain_action_close pull-right">Close</button>
        </div>
        <div class="panel-body text-center">
            <img src="{!! $dataProjectSample->pathFullImage() !!}">
        </div>
    </div>
@endsection