<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/29/2016
 * Time: 1:31 PM
 *
 * modelUser
 * dataUserImage
 *
 *
 */
?>
@extends('components.container.contain-action-10')
@section('tf_main_action_content')
    <div id="tf_action_height_fix" class="tf_action_height_fix tf-user-banner-image-view col-xm-12 col-sm-12 col-md-12 col-lg-12">
        <img alt="banner" src="{!! $dataUserImage->pathFullImage() !!}"/>
    </div>
@endsection
