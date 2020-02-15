<?php
/*
 * modelUser
 * dataRequestBuildPrice
 */
#user login
$dataUserLogin = $modelUser->loginUserInfo();
$loginUserId = $dataUserLogin->userId();
$pointOfUser = $dataUserLogin->point($loginUserId);
?>
@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1">
        <form name="frmRequestBuildNotify" class="form-horizontal " role="form" method='post' enctype="multipart/form-data" >
            <div class="form-group"></div>
            <div class="tf-color-red form-group text-center">
                Cost build: {!! $dataRequestBuildPrice->price() !!} Point
                <br/>
                Your point: {!! $pointOfUser !!}
            </div>
            <div class="form-group warning text-center tf-color-red">
                {!! trans('frontend_map.land_build_transaction_notify_point') !!}.
            </div>
            <div class="form-group">
                <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <a class="tf-link-white" href="{!! route('tf.point.online.package.get') !!}">
                        <button type="button" class="btn btn-primary">
                            {!! trans('frontend_point.button_buy_point') !!}
                        </button>
                    </a>
                    <button type="button" class="tf_main_contain_action_close btn btn-default">
                        {!! trans('frontend_point.button_later') !!}
                    </button>
                </div>
            </div>

        </form>
    </div>
@endsection