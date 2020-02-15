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
    <div class="tf-padding-30 tf-font-bold text-center col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        {!! trans('frontend_ads.image_report_success_notify') !!}.
    </div>
    <div class="tf-padding-20 text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <button class="tf_mater_reload btn btn-primary" type="button">
            {!! trans('frontend.button_close') !!}
        </button>
    </div>
@endsection
