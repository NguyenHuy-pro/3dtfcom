<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 4/27/2017
 * Time: 4:29 PM
 */
/*
 * modelUser
 * dataPointAccess
 */
$notifyContent = $dataPointAccess['notify'];
?>
@extends('point.online.index')
@section('online_content')
    <div class="panel panel-default tf-border-none">

        <div class="panel-body">
            <div class="row">
                <div class="tf-padding-none text-center tf-color-red col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    {!! $notifyContent !!}
                </div>
            </div>
        </div>


        <div class="panel-footer text-center tf-padding-none">
            <div class="row">
                <div class="text-center col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <a class="tf-padding-10 tf-link-full tf-bg-hover tf-color"
                       href="{!! route('tf.home') !!}">
                        To map
                    </a>
                </div>
                <div class="text-center col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <a class="tf-padding-10 tf-link-full tf-bg-hover tf-color"
                       href="{!! route('tf.point.online.package.get') !!}">
                        Continue
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection