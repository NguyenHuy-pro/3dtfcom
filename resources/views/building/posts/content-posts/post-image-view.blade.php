<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 2/11/2017
 * Time: 12:27 AM
 *
 * modelUser
 * dataBuildingPost
 * accessImageId
 *
 */
$dataBuildingPostImage = $dataBuildingPost->imageActivityInfo();
?>
@extends('components.container.contain-action-10')
@section('tf_main_action_content')
    <div id="tf_action_height_fix" class="tf_action_height_fix tf-padding-none col-xm-12 col-sm-12 col-md-12 col-lg-12">
        <div id="carousel-example-generic" class="tf_building_post_image_carousel carousel slide" data-ride="carousel"
             style="height: 100%;">
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                @if(count($dataBuildingPostImage) > 0)
                    @foreach($dataBuildingPostImage as $key => $postImage)
                        <div class="tf_building_post_image_item item @if($postImage->imageId() == $accessImageId) active @endif"
                             style="background-color: black; position: relative;">
                            <img style="max-width: 100%; max-height: 100%; position: absolute;left: 50%;top: 50%;padding: 20px;transform: translate(-50%, -50%);"
                                 src="{!! $postImage->pathFullImage() !!}">
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Controls -->
            @if(count($dataBuildingPostImage) > 1)
                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            @endif
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                var height = $('#tf_action_height_fix').outerHeight();
                $('.tf_building_post_image_item').css('height', height);
            });
        </script>
    </div>

@endsection
