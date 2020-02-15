<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/19/2016
 * Time: 11:18 AM
 *
 * $dataNotify
 *
 */

$hFunction = new Hfunction();

?>
@extends('components.container.contain-action-8')
@section('tf_main_action_content')
    <div class="panel panel-default tf-border-none tf_action_height_fix tf-padding-none tf-margin-bot-none ">
        <div class="panel-heading tf-bg tf-color-white tf-border-none ">
            <i class="tf-font-size-16 fa fa-file"></i>&nbsp;
            Information
            <span class="tf_main_contain_action_close tf-font-size-14 fa fa-times tf-link-red-bold  pull-right"></span>
        </div>
        <div class="panel-body">
            {!! $dataNotify->content() !!}
        </div>
    </div>
@endsection
