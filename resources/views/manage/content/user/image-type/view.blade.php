<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 */
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Image type detail
            <button class="btn btn-default btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <div class="tf-padding-20 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <em>Name :</em>
                <span class="tf-em-1-5">
                    {!! $dataImageType->name() !!}
                </span>
            </div>
        </div>
    </div>
@endsection