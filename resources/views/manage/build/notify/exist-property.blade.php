<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 7/13/2016
 * Time: 11:53 AM
 */
?>
@extends('manage.build.master')
@section('titlePage')
    Build
@endsection

@section('tf_m_build_main_content')
    <div class="text-center tf-bg-white tf-height-full tf-padding-30 col-xs-12 col-md-12 col-md-12 col-lg-12">
        Not found your project
        <br>
        <a href="{!! route('tf.m.index') !!}">To Panel</a>
    </div>
@endsection
