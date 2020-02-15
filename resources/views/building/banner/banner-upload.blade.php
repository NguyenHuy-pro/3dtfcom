<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/27/2016
 * Time: 11:48 AM
 */
/*
 *
 * $dataBuilding
 *
 */

$hFunction = new Hfunction();
$buildingId = $dataBuilding->buildingId();
?>
@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 tf-padding-top-50 tf-padding-bot-50">
        <form id="frmBuildingBannerAdd" name="frmBuildingBannerAdd" class="form-horizontal" role="form" method='post'
              enctype="multipart/form-data" action="{!! route('tf.building.banner.add.post', $buildingId) !!}">
            <div class="form-group">

            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">
                    {!! trans('frontend_building.posts_banner_upload_label_image') !!}:
                </label>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <?php
                        $hFunction->selectOneImage('fileImage', 'fileImage');
                    ?>
                </div>
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                <button class="tf_banner_add_post btn btn-primary tf-link-white " type="button">
                    {!! trans('frontend.button_agree') !!}
                </button>
                <button class="tf_main_contain_action_close btn btn-default tf-link " type="button">
                    {!! trans('frontend.button_close') !!}
                </button>
            </div>
        </form>
    </div>
@endsection
