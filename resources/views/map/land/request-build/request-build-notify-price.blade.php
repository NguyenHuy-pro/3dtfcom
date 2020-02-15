<?php
/*
 * modelUser
 * dataBuilding
 */
?>
@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1">
        <form name="frmRequestBuildNotify" class="form-horizontal " role="form" method='post' enctype="multipart/form-data" >
            <div class="form-group"></div>
            <div class="form-group warning tf-padding-30 tf-color-red text-center ">
                The system does not support this size
            </div>
            <div class="form-group">
                <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <button type="button" class="tf_main_contain_action_close btn btn-primary">
                        {!! trans('frontend_map.button_close') !!}
                    </button>
                </div>
            </div>

        </form>
    </div>
@endsection