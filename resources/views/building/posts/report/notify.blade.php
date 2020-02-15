<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/16/2016
 * Time: 8:41 AM
 *
 * $modelUser
 * $dataBanner
 *
 *
 */
?>
@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf-padding-20 text-center">
        <p>
            <b>{!! trans('frontend_building.post_report_notify_content') !!}.</b>
        </p>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf-padding-20 text-center">
        <button class="tf_main_contain_action_close btn btn-default" type="button">
            {!! trans('frontend_map.button_close') !!}
        </button>
    </div>
@endsection
