<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/29/2016
 * Time: 1:31 PM
 *
 * modelUser
 * dataBuildingBanner
 *
 *
 */
?>
@extends('components.container.contain-action-10')
@section('tf_main_action_content')
    <div id="tf_action_height_fix" class="tf_action_height_fix tf-padding-none col-xm-12 col-sm-12 col-md-12 col-lg-12"
         style="position: relative; background-color: black;">
        <img style="max-width: 100%; max-height: 100%; position: absolute;left: 50%;top: 50%;transform: translate(-50%, -50%);"
             alt="banner" src="{!! $dataBuildingBanner->pathFullImage() !!}"/>
    </div>
@endsection
