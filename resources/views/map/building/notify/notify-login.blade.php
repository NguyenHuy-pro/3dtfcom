<?php
/*
 *
 * $dataBuilding
 *
 */

$hFunction = new Hfunction();
if (count($dataBuilding) > 0) {
    $returnUrl = route('tf.home', $dataBuilding->alias());
} else {
    $returnUrl = null;
}
?>
@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    <div class="panel panel-default tf-border-none tf-padding-none tf-margin-bot-none">
        <div class="panel-body">
            <div class="tf-padding-30 text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                You must login to use this Feature.
            </div>
            <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <a class="tf_main_login_get btn btn-primary " data-href="{!! route('tf.login.get') !!}">
                    Sign in
                </a>
                <a class="tf_main_contain_action_close btn btn-default ">
                    {!! trans('frontend_map.button_later') !!}
                </a>
            </div>

        </div>

    </div>
@endsection