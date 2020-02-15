<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 2/11/2017
 * Time: 12:27 AM
 *
 * modelUser
 * dataBannerImage
 *
 */
?>
@extends('components.container.contain-action-10')
@section('tf_main_action_content')
    <div id="tf_action_height_fix" class="tf_action_height_fix tf-banner-image-view col-xm-12 col-sm-12 col-md-12 col-lg-12">
        <a @if(!empty($dataBannerImage->website())) href="http://{!! $dataBannerImage->website() !!}" @endif>
            <img alt="full-image" src="{!! $dataBannerImage->pathFullImage() !!}">
        </a>
    </div>
@endsection
